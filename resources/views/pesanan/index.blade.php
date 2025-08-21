@extends('layouts.app')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
        <h1 class="text-xl font-semibold text-gray-900">Daftar Pesanan</h1>
        <p class="mt-2 text-sm text-gray-700">Kelola semua pesanan laundry di sistem</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="{{ route('pesanan.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
            Tambah Pesanan
        </a>
    </div>
</div>

<div class="mt-8 flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layanan</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Masuk</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($pesanan as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                #{{ $order->id_pesanan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $order->pelanggan->nama }}</div>
                                <div class="text-sm text-gray-500">{{ $order->pelanggan->nomor_telepon }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->jenis_layanan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->jumlah_pakaian }} item
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 text-xs font-semibold rounded-full
                                    @if($order->status == 'Pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'Dikerjakan') bg-orange-100 text-orange-800
                                    @elseif($order->status == 'Selesai') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->tanggal_masuk->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $order->admin ? $order->admin->nama_admin : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex space-x-2">
                                    <!-- Quick Status Update -->
                                    @if($order->status !== 'Telah Diambil')
                                    <form action="{{ route('pesanan.updateStatus', $order) }}" method="POST" class="inline">
                                        @csrf

                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded px-2 py-1">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="dalam proses" {{ $order->status == 'dalam proses' ? 'selected' : '' }}>Dalam Proses</option>
                                            <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="diambil" {{ $order->status == 'diambil' ? 'selected' : '' }}>Telah Diambil</option>
                                        </select>
                                    </form>
                                    @endif
                                    
                                    <a href="{{ route('pesanan.show', $order) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                                    <a href="{{ route('pesanan.edit', $order) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('pesanan.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Belum ada pesanan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-6">
    {{ $pesanan->links() }}
</div>
@endsection
