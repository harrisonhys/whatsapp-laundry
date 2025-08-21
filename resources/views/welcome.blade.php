@extends('layouts.app')

@section('title', 'Laundry Management System')

@section('content')
<div class="text-center">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Selamat Datang di Laundry Management System</h1>
        <p class="text-xl text-gray-600">Sistem manajemen laundry dengan integrasi WhatsApp API</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-6xl mx-auto">
        <!-- Dashboard Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Dashboard</dt>
                            <dd class="text-lg font-medium text-gray-900">Lihat statistik & pesanan</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Buka Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Pesanan Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pesanan</dt>
                            <dd class="text-lg font-medium text-gray-900">Kelola pesanan laundry</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('pesanan.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                        Lihat Pesanan
                    </a>
                </div>
            </div>
        </div>

        <!-- Pelanggan Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pelanggan</dt>
                            <dd class="text-lg font-medium text-gray-900">Kelola data pelanggan</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('pelanggan.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                        Lihat Pelanggan
                    </a>
                </div>
            </div>
        </div>

        <!-- Admin Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Admin</dt>
                            <dd class="text-lg font-medium text-gray-900">Kelola akun admin</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('admin.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Lihat Admin
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Laporan</dt>
                            <dd class="text-lg font-medium text-gray-900">Laporan & analitik</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('dashboard.report') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                        Lihat Laporan
                    </a>
                </div>
            </div>
        </div>

        <!-- WhatsApp Info Card -->
        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-green-400 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">WhatsApp API</dt>
                            <dd class="text-lg font-medium text-gray-900">Webhook: /api/whatsapp/webhook</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="inline-flex items-center px-4 py-2 border border-green-300 text-sm font-medium rounded-md text-green-800 bg-green-100">
                        Siap Digunakan
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- WhatsApp Message Format -->
    <div class="mt-12 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Format Pesan WhatsApp untuk Pemesanan</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <pre class="text-sm text-gray-800 whitespace-pre-line">Nama: John Doe
Jumlah Pakaian: 5
Jenis Layanan: Cuci/Setrika/Keduanya</pre>
                </div>
                <p class="mt-3 text-sm text-gray-500">
                    Kirim pesan dengan format di atas ke nomor WhatsApp yang terdaftar untuk membuat pesanan otomatis.
                </p>
            </div>
        </div>
    </div>

    <!-- Footer Info -->
    <div class="mt-8 text-center text-sm text-gray-500">
        <p>Laravel {{ app()->version() }} | Laundry Management System</p>
    </div>
</div>
@endsection
