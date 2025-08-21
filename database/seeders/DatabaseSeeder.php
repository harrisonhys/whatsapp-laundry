<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin
        Admin::create([
            'nama_admin' => 'Administrator',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password123'),
        ]);

        // Create sample customers
        Pelanggan::create([
            'nama' => 'Budi Santoso',
            'nomor_telepon' => '62812345678',
        ]);

        Pelanggan::create([
            'nama' => 'Siti Nurhaliza',
            'nomor_telepon' => '62813456789',
        ]);
    }
}
