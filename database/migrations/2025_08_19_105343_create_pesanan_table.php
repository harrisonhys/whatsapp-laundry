<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->onDelete('cascade');
            $table->enum('jenis_layanan', ['Cuci', 'Setrika', 'Keduanya']);
            $table->integer('jumlah_pakaian');
            $table->datetime('tanggal_masuk');
            $table->datetime('tanggal_keluar')->nullable();
            $table->enum('status', ['Pending', 'Dikerjakan', 'Selesai', 'Telah Diambil'])->default('Pending');
            $table->foreignId('id_admin')->nullable()->constrained('admins', 'id_admin')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
