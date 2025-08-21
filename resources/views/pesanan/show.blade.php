@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Detail Pesanan #{{ $pesanan->id_pesanan }}</h2>
                <div class="flex space-x-3">
                    <a href="{{ route('pesanan.edit', $pesanan->id_pesanan) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('pesanan.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Status Badge -->
            <div class="mb-6">
                @php
                    $statusColor = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'dalam_proses' => 'bg-blue-100 text-blue-800',
                        'selesai' => 'bg-green-100 text-green-800',
                        'diambil' => 'bg-gray-100 text-gray-800'
                    ];
                @endphp
                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColor[$pesanan->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst(str_replace('_', ' ', $pesanan->status)) }}
                </span>
            </div>

            <!-- Data Pesanan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">ID Pesanan</h3>
                        <p class="text-lg font-semibold text-gray-900">#{{ $pesanan->id_pesanan }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Pelanggan</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $pesanan->pelanggan->nama }}</p>
                        <p class="text-sm text-gray-600">{{ $pesanan->pelanggan->nomor_telepon }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Jenis Layanan</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $pesanan->jenis_layanan }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Jumlah & Berat</h3>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $pesanan->jumlah_pakaian }} pcs
                            @if($pesanan->berat)
                                ({{ $pesanan->berat }} kg)
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Harga per KG</h3>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($pesanan->harga_per_kg, 0, ',', '.') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Total Harga</h3>
                        <p class="text-lg font-semibold text-green-600">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Masuk</h3>
                        <p class="text-lg font-semibold text-gray-900">{{ $pesanan->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-sm font-medium text-gray-500 mb-1">Tanggal Selesai</h3>
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $pesanan->tanggal_selesai ? $pesanan->tanggal_selesai->format('d M Y H:i') : 'Belum ditentukan' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($pesanan->catatan)
            <div class="mt-6">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-500 mb-2">Catatan</h3>
                    <p class="text-gray-900 whitespace-pre-line">{{ $pesanan->catatan }}</p>
                </div>
            </div>
            @endif

            <!-- Admin Info -->
            @if($pesanan->admin)
            <div class="mt-6">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="text-sm font-medium text-blue-700 mb-1">Admin yang Menangani</h3>
                    <p class="text-blue-900 font-semibold">{{ $pesanan->admin->nama_admin }}</p>
                    <p class="text-blue-700 text-sm">{{ $pesanan->admin->email }}</p>
                </div>
            </div>
            @endif

            <!-- Timeline Status -->
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Timeline Status</h3>
                <div class="flow-root">
                    <ul class="-mb-8">
                        <!-- Pesanan Dibuat -->
                        <li>
                            <div class="relative pb-8">
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                <div class="relative flex items-start space-x-3">
                                    <div>
                                        <div class="relative px-1">
                                            <div class="h-8 w-8 bg-green-500 rounded-full ring-8 ring-white flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div>
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-900">Pesanan Dibuat</span>
                                            </div>
                                            <p class="mt-0.5 text-sm text-gray-500">{{ $pesanan->created_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <!-- Status Saat Ini -->
                        @if($pesanan->status !== 'pending')
                        <li>
                            <div class="relative pb-8">
                                @if($pesanan->status !== 'diambil')
                                <span class="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                @endif
                                <div class="relative flex items-start space-x-3">
                                    <div>
                                        <div class="relative px-1">
                                            <div class="h-8 w-8 bg-blue-500 rounded-full ring-8 ring-white flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div>
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $pesanan->status)) }}</span>
                                            </div>
                                            <p class="mt-0.5 text-sm text-gray-500">{{ $pesanan->updated_at->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif

                        <!-- Estimasi Selesai -->
                        @if($pesanan->tanggal_selesai && $pesanan->status !== 'selesai' && $pesanan->status !== 'diambil')
                        <li>
                            <div class="relative">
                                <div class="relative flex items-start space-x-3">
                                    <div>
                                        <div class="relative px-1">
                                            <div class="h-8 w-8 bg-yellow-500 rounded-full ring-8 ring-white flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div>
                                            <div class="text-sm">
                                                <span class="font-medium text-gray-900">Estimasi Selesai</span>
                                            </div>
                                            <p class="mt-0.5 text-sm text-gray-500">{{ $pesanan->tanggal_selesai->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            @if($pesanan->status !== 'diambil')
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                <div class="flex flex-wrap gap-3">
                    @if($pesanan->status === 'pending')
                        <form method="POST" action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="dalam_proses">
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                Mulai Proses
                            </button>
                        </form>
                    @endif

                    @if($pesanan->status === 'dalam_proses')
                        <form method="POST" action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="selesai">
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                                Tandai Selesai
                            </button>
                        </form>
                    @endif

                    @if($pesanan->status === 'selesai')
                        <form method="POST" action="{{ route('pesanan.updateStatus', $pesanan->id_pesanan) }}" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="diambil">
                            <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700">
                                Tandai Diambil
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
