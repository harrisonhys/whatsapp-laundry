<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_pelanggan',
        'jenis_layanan',
        'jumlah_pakaian',
        'berat',
        'harga_per_kg',
        'total_harga',
        'tanggal_masuk',
        'tanggal_keluar',
        'tanggal_selesai',
        'status',
        'id_admin',
        'catatan',
    ];

    protected $casts = [
        'tanggal_masuk' => 'datetime',
        'tanggal_keluar' => 'datetime',
        'tanggal_selesai' => 'datetime',
        'berat' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'total_harga' => 'decimal:2',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan', 'id_pelanggan');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    public function getDurasiPengerjaanAttribute()
    {
        if ($this->tanggal_masuk && $this->tanggal_keluar) {
            return $this->tanggal_masuk->diffInDays($this->tanggal_keluar);
        }
        return null;
    }
}
