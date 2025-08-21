@extends('layouts.app')

@section('title', 'Detail Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Detail Admin</h2>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.edit', $admin->id_admin) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('admin.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Data Admin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">ID Admin</label>
                        <p class="text-lg font-semibold text-gray-900">#{{ $admin->id_admin }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Admin</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $admin->nama_admin }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $admin->email }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Bergabung Sejak</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $admin->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Terakhir Diupdate</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $admin->updated_at->format('d M Y H:i') }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Total Pesanan Ditangani</label>
                        <p class="text-lg font-semibold text-gray-900">{{ $admin->pesanan->count() }} pesanan</p>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pesanan yang Ditangani -->
            <div class="mt-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4">Pesanan yang Ditangani</h3>
                
                @if($admin->pesanan->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Layanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($admin->pesanan->sortByDesc('created_at')->take(10) as $pesanan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <a href="{{ route('pesanan.show', $pesanan->id_pesanan) }}" class="text-blue-600 hover:text-blue-900">
                                            #{{ $pesanan->id_pesanan }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesanan->pelanggan->nama }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesanan->jenis_layanan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Rp {{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColor = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'dalam_proses' => 'bg-blue-100 text-blue-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'diambil' => 'bg-gray-100 text-gray-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor[$pesanan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst(str_replace('_', ' ', $pesanan->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $pesanan->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($admin->pesanan->count() > 10)
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-500">Menampilkan 10 pesanan terbaru dari {{ $admin->pesanan->count() }} total pesanan</p>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pesanan</h3>
                        <p class="mt-1 text-sm text-gray-500">Admin ini belum menangani pesanan apapun.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
