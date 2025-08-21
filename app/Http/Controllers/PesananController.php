<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Pelanggan;
use App\Models\Admin;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PesananController extends Controller
{
    private $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }

    public function index()
    {
        $pesanan = Pesanan::with(['pelanggan', 'admin'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('pesanan.index', compact('pesanan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        return view('pesanan.create', compact('pelanggan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'jenis_layanan' => 'required|in:Cuci Kering,Cuci Setrika,Setrika Saja,Dry Clean',
            'jumlah_pakaian' => 'required|integer|min:1',
            'berat' => 'nullable|numeric|min:0',
            'harga_per_kg' => 'required|numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:pending,dalam_proses,selesai,diambil',
            'catatan' => 'nullable|string',
        ]);

        Pesanan::create([
            'id_pelanggan' => $request->id_pelanggan,
            'jenis_layanan' => $request->jenis_layanan,
            'jumlah_pakaian' => $request->jumlah_pakaian,
            'berat' => $request->berat,
            'harga_per_kg' => $request->harga_per_kg,
            'total_harga' => $request->total_harga,
            'tanggal_masuk' => Carbon::now(),
            'tanggal_selesai' => $request->tanggal_selesai ? Carbon::parse($request->tanggal_selesai) : null,
            'status' => $request->status,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dibuat');
    }

    public function show(Pesanan $pesanan)
    {
        $pesanan->load(['pelanggan', 'admin']);
        return view('pesanan.show', compact('pesanan'));
    }

    public function edit(Pesanan $pesanan)
    {
        $pelanggan = Pelanggan::all();
        $admins = Admin::all();
        return view('pesanan.edit', compact('pesanan', 'pelanggan', 'admins'));
    }

    public function update(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'id_pelanggan' => 'required|exists:pelanggan,id_pelanggan',
            'jenis_layanan' => 'required|in:Cuci Kering,Cuci Setrika,Setrika Saja,Dry Clean',
            'jumlah_pakaian' => 'required|integer|min:1',
            'berat' => 'nullable|numeric|min:0',
            'harga_per_kg' => 'required|numeric|min:0',
            'total_harga' => 'required|numeric|min:0',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:pending,dalam_proses,selesai,diambil',
            'catatan' => 'nullable|string',
            'id_admin' => 'nullable|exists:admins,id_admin',
        ]);

        $oldStatus = $pesanan->status;
        
        $pesanan->update($request->only([
            'id_pelanggan', 'jenis_layanan', 'jumlah_pakaian', 'berat', 
            'harga_per_kg', 'total_harga', 'tanggal_selesai', 'status', 
            'catatan', 'id_admin'
        ]));

        // Update tanggal_keluar when status becomes "diambil"
        if ($request->status === 'diambil' && $oldStatus !== 'diambil') {
            $pesanan->update(['tanggal_keluar' => Carbon::now()]);
        }

        // Send WhatsApp notification if status changed
        if ($oldStatus !== $request->status && in_array($request->status, ['dalam_proses', 'selesai', 'diambil'])) {
            $this->whatsAppService->sendStatusUpdate($pesanan, $request->status);
        }

        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil diupdate');
    }

    public function destroy(Pesanan $pesanan)
    {
        $pesanan->delete();
        return redirect()->route('pesanan.index')
            ->with('success', 'Pesanan berhasil dihapus');
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $request->validate([
            'status' => 'required|in:pending,dalam_proses,selesai,diambil',
        ]);

        $oldStatus = $pesanan->status;
        $pesanan->update(['status' => $request->status]);

        // Update tanggal_keluar when status becomes "diambil"
        if ($request->status === 'diambil' && $oldStatus !== 'diambil') {
            $pesanan->update(['tanggal_keluar' => Carbon::now()]);
        }

        // Send WhatsApp notification
        if (in_array($request->status, ['dalam_proses', 'selesai', 'diambil'])) {
            $this->whatsAppService->sendStatusUpdate($pesanan, $request->status);
        }

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diupdate');
    }
}
