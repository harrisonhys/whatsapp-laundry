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
        Schema::table('pesanan', function (Blueprint $table) {
            $table->decimal('berat', 8, 2)->nullable()->after('jumlah_pakaian');
            $table->decimal('harga_per_kg', 10, 2)->default(5000)->after('berat');
            $table->decimal('total_harga', 12, 2)->after('harga_per_kg');
            $table->datetime('tanggal_selesai')->nullable()->after('total_harga');
            $table->text('catatan')->nullable()->after('tanggal_selesai');
            
            // Update enum values for jenis_layanan
            $table->dropColumn('jenis_layanan');
        });
        
        // Re-add jenis_layanan with new values
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('jenis_layanan', ['Cuci Kering', 'Cuci Setrika', 'Setrika Saja', 'Dry Clean'])->after('id_pelanggan');
        });
        
        // Update enum values for status
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('status', ['pending', 'dalam_proses', 'selesai', 'diambil'])->default('pending')->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn(['berat', 'harga_per_kg', 'total_harga', 'tanggal_selesai', 'catatan']);
            
            // Restore original jenis_layanan
            $table->dropColumn('jenis_layanan');
        });
        
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('jenis_layanan', ['Cuci', 'Setrika', 'Keduanya'])->after('id_pelanggan');
        });
        
        // Restore original status
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        
        Schema::table('pesanan', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Dikerjakan', 'Selesai', 'Telah Diambil'])->default('Pending');
        });
    }
};
