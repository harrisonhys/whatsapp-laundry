# WhatsApp Webhook Testing Guide

File ini berisi panduan untuk testing webhook WhatsApp API pada Laundry Management System.

## File Testing yang Tersedia

### 1. `webhook-test.http` 
File REST Client untuk VS Code dengan extension REST Client
- Berisi 8 test case untuk webhook
- Format yang mudah dibaca dan dijalankan langsung dari VS Code

### 2. `test-webhook.sh`
Script bash untuk testing via terminal
- Executable script dengan 8 test case
- Jalankan dengan: `./test-webhook.sh`
- Memberikan output status dan hasil

### 3. `postman-collection.json`
Collection Postman untuk testing
- Import ke Postman untuk testing GUI
- Berisi environment variable untuk base URL
- Lengkap dengan webhook dan API tests

## Cara Menjalankan Testing

### Menggunakan VS Code REST Client
1. Install extension "REST Client" di VS Code
2. Buka file `webhook-test.http`
3. Klik "Send Request" pada setiap test case

### Menggunakan Bash Script
```bash
# Pastikan script executable
chmod +x test-webhook.sh

# Jalankan testing
./test-webhook.sh
```

### Menggunakan Postman
1. Buka Postman
2. Import file `postman-collection.json`
3. Set environment variable `baseUrl` ke `http://127.0.0.1:8000`
4. Jalankan collection atau individual requests

### Menggunakan cURL Manual
```bash
# Test cuci kering
curl -X POST "http://127.0.0.1:8000/api/whatsapp/webhook" \
  -H "Content-Type: application/json" \
  -d '{
    "phone": "6281234567890",
    "message": "Pesan cuci kering 5kg",
    "timestamp": "2025-08-20 08:30:00"
  }'
```

## Test Cases yang Tersedia

| Test | Pesan | Expected Result |
|------|-------|----------------|
| 1 | "Pesan cuci kering 5kg" | ✅ Buat pesanan cuci kering |
| 2 | "Pesan setrika 3 potong pakaian" | ✅ Buat pesanan setrika |
| 3 | "Pesan cuci setrika 2kg" | ✅ Buat pesanan cuci+setrika |
| 4 | "Pesan dry cleaning 4 potong" | ✅ Buat pesanan dry cleaning |
| 5 | "Halo, apakah toko buka?" | ❌ Tidak buat pesanan |
| 6 | "Order laundry cuci kering untuk 7 kg pakaian" | ✅ Buat pesanan cuci kering |
| 7 | "cuci 2kg" | ✅ Buat pesanan cuci |
| 8 | "Halo, saya mau pesan cuci setrika untuk 6 potong baju. Kapan bisa diambil?" | ✅ Buat pesanan cuci+setrika |

## Monitoring Hasil

Setelah menjalankan testing, periksa hasil di:

1. **Dashboard**: `http://127.0.0.1:8000/dashboard`
   - Lihat statistik pesanan terbaru
   
2. **Daftar Pesanan**: `http://127.0.0.1:8000/pesanan`
   - Lihat pesanan yang berhasil dibuat
   
3. **Daftar Pelanggan**: `http://127.0.0.1:8000/pelanggan`
   - Lihat pelanggan yang auto-created

## Expected Behavior

### Pesan yang Valid (Membuat Pesanan)
- Pesan mengandung kata kunci: "pesan", "order", "cuci", "setrika", "dry cleaning"
- Pesan mengandung jumlah: "2kg", "3 potong", "5 item"
- Sistem akan:
  1. Parse pesan untuk ekstrak jenis layanan dan jumlah
  2. Auto-create pelanggan jika belum ada (berdasarkan nomor telepon)
  3. Buat pesanan baru dengan status "pending"
  4. Return HTTP 200 dengan pesan sukses

### Pesan yang Tidak Valid
- Pesan umum seperti "Halo", "Terima kasih", dll.
- Sistem akan:
  1. Return HTTP 200 (tidak error)
  2. Tidak membuat pesanan
  3. Log pesan untuk reference

## Troubleshooting

### Server Tidak Berjalan
```bash
# Start Laravel server
php artisan serve

# Start Vite (untuk CSS)
npm run dev
```

### Error 419 (CSRF)
- Webhook endpoint sudah dikecualikan dari CSRF verification
- Pastikan `api/whatsapp/webhook` ada di `app/Http/Middleware/VerifyCsrfToken.php`

### Error 404
- Pastikan route webhook terdaftar di `routes/api.php`
- Periksa URL: `http://127.0.0.1:8000/api/whatsapp/webhook`

### Database Error
```bash
# Migrate database
php artisan migrate

# Seed initial data
php artisan db:seed
```

## Tips

1. **Monitor Laravel Logs**: Lihat `storage/logs/laravel.log` untuk debugging
2. **Check Network**: Pastikan port 8000 tidak diblok firewall
3. **Database Inspect**: Gunakan SQLite browser untuk lihat data langsung
4. **Testing Incremental**: Jalankan satu test dulu, lalu cek hasilnya sebelum lanjut
