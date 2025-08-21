<?php

namespace App\Services;

use App\Models\Pelanggan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private $token;
    private $apiUrl;

    public function __construct()
    {
        $this->token = env('WA_API_TOKEN', 'xxxx');
        $this->apiUrl = env('WA_API_URL', 'https://app.ruangwa.id/api/send_message');
    }

    public function processIncomingMessage($data)
    {
        // Support both RuangWA.id format and our test format
        $isGroup = false;
        
        // RuangWA.id format check
        if (isset($data['isGroup'])) {
            $isGroup = $data['isGroup'];
        }
        
        // Our test format - always treat as chat
        if (isset($data['phone']) && isset($data['message'])) {
            $isGroup = false;
        }
        
        if ($isGroup) {
            return ['status' => 'ignored', 'message' => 'Not a personal chat message'];
        }

        // Extract phone number and message from different formats
        $phoneNumber = null;
        $message = null;
        
        // RuangWA.id format
        if (isset($data['phone'])) {
            $phoneNumber = $this->formatPhoneNumber($data['phone']);
            $message = $data['message'] ?? '';
        }
        
        // Our test format
        if (isset($data['phone'])) {
            $phoneNumber = $this->formatPhoneNumber($data['phone']);
            $message = $data['message'] ?? '';
        }
        
        if (!$phoneNumber || !$message) {
            return ['status' => 'error', 'message' => 'Missing number number or message'];
        }

        // Parse the order message
        $orderData = $this->parseOrderMessage($message, $phoneNumber);
        
        if (!$orderData) {
            return ['status' => 'ignored', 'message' => 'Message does not contain order request'];
        }

        // Create or get customer
        $pelanggan = $this->getOrCreateCustomer($orderData['nama'], $phoneNumber);

        // Create order
        $pesanan = $this->createOrder($pelanggan, $orderData);

        return [
            'status' => 'success',
            'message' => 'Order created successfully',
            'order_id' => $pesanan->id_pesanan
        ];
    }

    private function parseOrderMessage($message, $phoneNumber = null)
    {
        $message = strtolower(trim($message));
        
        // Check if message contains order keywords
        $orderKeywords = ['pesan', 'order', 'cuci', 'setrika', 'laundry', 'dry cleaning'];
        $hasOrderKeyword = false;
        
        foreach ($orderKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                $hasOrderKeyword = true;
                break;
            }
        }
        
        if (!$hasOrderKeyword) {
            return null; // Not an order message
        }
        
        // Extract service type
        $jenisLayanan = 'Cuci Kering'; // Default
        
        if (strpos($message, 'dry cleaning') !== false || strpos($message, 'dry clean') !== false) {
            $jenisLayanan = 'Dry Clean';
        } elseif (strpos($message, 'cuci setrika') !== false || strpos($message, 'cuci dan setrika') !== false) {
            $jenisLayanan = 'Cuci Setrika';
        } elseif (strpos($message, 'setrika') !== false) {
            $jenisLayanan = 'Setrika Saja';
        } elseif (strpos($message, 'cuci kering') !== false || strpos($message, 'cuci') !== false) {
            $jenisLayanan = 'Cuci Kering';
        }
        
        // Extract quantity
        $jumlahPakaian = 1; // Default
        
        // Look for patterns like "5kg", "3 potong", "2 item", etc.
        if (preg_match('/(\d+)\s*(kg|kilo|kilogram)/i', $message, $matches)) {
            $jumlahPakaian = (int) $matches[1];
        } elseif (preg_match('/(\d+)\s*(potong|pcs|piece|item|buah)/i', $message, $matches)) {
            $jumlahPakaian = (int) $matches[1];
        } elseif (preg_match('/(\d+)/', $message, $matches)) {
            $jumlahPakaian = (int) $matches[1];
        }
        
        // Generate customer name from phone number if not provided
        $nama = 'Pelanggan ' . substr($phoneNumber, -4); // Use last 4 digits
        
        // Calculate estimated price
        $hargaPerKg = [
            'Cuci Kering' => 7000,
            'Cuci Setrika' => 8000,
            'Setrika Saja' => 3000,
            'Dry Clean' => 15000
        ];
        
        $totalHarga = ($hargaPerKg[$jenisLayanan] ?? 5000) * $jumlahPakaian;
        
        return [
            'nama' => $nama,
            'jumlah_pakaian' => $jumlahPakaian,
            'jenis_layanan' => $jenisLayanan,
            'total_harga' => $totalHarga,
            'catatan' => $message // Store original message as notes
        ];
    }

    private function getOrCreateCustomer($nama, $phoneNumber)
    {
        return Pelanggan::firstOrCreate(
            ['nomor_telepon' => $phoneNumber],
            ['nama' => $nama]
        );
    }

    private function createOrder($pelanggan, $orderData)
    {
        return Pesanan::create([
            'id_pelanggan' => $pelanggan->id_pelanggan,
            'jenis_layanan' => $orderData['jenis_layanan'],
            'jumlah_pakaian' => $orderData['jumlah_pakaian'],
            'total_harga' => $orderData['total_harga'],
            'catatan' => $orderData['catatan'],
            'tanggal_masuk' => Carbon::now(),
            'status' => 'pending'
        ]);
    }

    public function sendMessage($phoneNumber, $message)
    {
        try {
            $response = Http::asForm()->post($this->apiUrl, [
                'token' => $this->token,
                'number' => $this->formatPhoneNumber($phoneNumber),
                'message' => $message
            ]);

            Log::info('WhatsApp message sent', [
                'phone' => $phoneNumber,
                'message' => $message,
                'response' => $response->body()
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Failed to send WhatsApp message', [
                'phone' => $phoneNumber,
                'message' => $message,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public function sendStatusUpdate($pesanan, $newStatus)
    {
        $pelanggan = $pesanan->pelanggan;
        $message = $this->getStatusMessage($newStatus);
        
        return $this->sendMessage($pelanggan->nomor_telepon, $message);
    }

    private function getStatusMessage($status)
    {
        $messages = [
            'pending' => 'Pesanan laundry anda sedang menunggu konfirmasi.',
            'dalam_proses' => 'Pesanan laundry anda saat ini sedang dikerjakan',
            'selesai' => 'Pesanan laundry anda saat ini sudah selesai dan siap diambil.',
            'diambil' => 'Pesanan laundry anda sudah diambil pada tanggal ' .
                              Carbon::now()->format('d/m/Y H:i') .
                              '. Terimakasih sudah menggunakan layanan kami.'
        ];

        return $messages[$status] ?? 'Status pesanan anda telah diupdate.';
    }

    private function formatPhoneNumber($phoneNumber)
    {
        // Remove any non-numeric characters
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);
        
        // Convert to international format
        if (substr($phoneNumber, 0, 1) == '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 2) != '62') {
            $phoneNumber = '62' . $phoneNumber;
        }
        
        return $phoneNumber;
    }
}
