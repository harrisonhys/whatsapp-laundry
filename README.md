# Aplikasi Laundry Management SystemSistem manajemen laundry dengan integrasi WhatsApp API untuk pemesanan otomatis dan notifikasi status.## Fitur Utama### 1. Integrasi WhatsApp API- **Callback Endpoint**: Menerima pesan dari WhatsApp API- **Format Pemesanan**:   ```  Nama: John Doe  Jumlah Pakaian: 5  Jenis Layanan: Cuci/Setrika/Keduanya  ```- **Notifikasi Status**: Otomatis mengirim WhatsApp ketika status pesanan berubah### 2. Dashboard Admin- Statistik pesanan real-time- Daftar pesanan terbaru- Navigasi mudah ke semua modul### 3. Manajemen Pesanan- CRUD lengkap untuk pesanan- Update status dengan notifikasi WhatsApp otomatis- Status: Pending, Dikerjakan, Selesai, Telah Diambil### 4. Manajemen Pelanggan & Admin- CRUD pelanggan dengan riwayat pesanan- CRUD admin dengan tracking pesanan yang dikerjakan### 5. Laporan- Laporan lengkap semua pesanan- Informasi admin yang mengerjakan- Durasi pengerjaan pesanan- Statistik summary## Teknologi- **Backend**: Laravel 10- **Frontend**: Tailwind CSS- **Database**: SQLite (development) / MySQL (production)- **WhatsApp API**: RuangWA.id## Struktur Database### Tabel `pelanggan`- `id_pelanggan` (Primary Key)- `nama`- `nomor_telepon`### Tabel `pesanan`- `id_pesanan` (Primary Key)- `id_pelanggan` (Foreign Key)- `jenis_layanan` (Cuci, Setrika, Keduanya)- `jumlah_pakaian`- `tanggal_masuk`- `tanggal_keluar`- `status` (Pending, Dikerjakan, Selesai, Telah Diambil)- `id_admin` (Foreign Key)### Tabel `admins`- `id_admin` (Primary Key)- `nama_admin`- `email`- `password`## Instalasi

1. **Setup Laravel project**
   ```bash
   php artisan key:generate
   ```

2. **Setup database (SQLite default)**
   ```bash
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```

3. **Konfigurasi WhatsApp API di `.env`**
   ```
   WA_API_TOKEN=your_token_here
   WA_API_URL=https://app.ruangwa.id/api/send_message
   ```

4. **Build frontend assets**
   ```bash
   npm run dev
   ```

5. **Jalankan server**
   ```bash
   php artisan serve
   ```

## WhatsApp Webhook
- **URL**: `http://your-domain.com/api/whatsapp/webhook`
- **Method**: ANY (GET/POST)

## Akun Default
- **Admin**: admin@laundry.com / password123

## Flow Pemesanan

1. Customer mengirim WhatsApp dengan format yang ditentukan
2. WhatsApp API mengirim callback ke endpoint sistem
3. Sistem generate pesanan baru dan simpan ke database
4. Admin dapat update status pesanan dari dashboard
5. Sistem otomatis mengirim notifikasi WhatsApp ke customer
