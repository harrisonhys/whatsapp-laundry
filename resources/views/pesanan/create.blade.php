@extends('layouts.app')

@section('title', 'Tambah Pesanan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white overflow-hidden shadow-sm rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Tambah Pesanan Baru</h2>
            
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('pesanan.store') }}" id="pesananForm">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-6">
                        <!-- Pelanggan -->
                        <div>
                            <label for="id_pelanggan" class="block text-sm font-medium text-gray-700 mb-2">
                                Pelanggan
                            </label>
                            <select name="id_pelanggan" 
                                    id="id_pelanggan" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                <option value="">Pilih Pelanggan</option>
                                @foreach($pelanggan as $customer)
                                    <option value="{{ $customer->id_pelanggan }}" 
                                            {{ old('id_pelanggan') == $customer->id_pelanggan ? 'selected' : '' }}>
                                        {{ $customer->nama }} - {{ $customer->nomor_telepon }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_pelanggan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jenis Layanan -->
                        <div>
                            <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Layanan
                            </label>
                            <select name="jenis_layanan" 
                                    id="jenis_layanan" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                <option value="">Pilih Jenis Layanan</option>
                                <option value="Cuci Kering" {{ old('jenis_layanan') == 'Cuci Kering' ? 'selected' : '' }}>Cuci Kering</option>
                                <option value="Cuci Setrika" {{ old('jenis_layanan') == 'Cuci Setrika' ? 'selected' : '' }}>Cuci Setrika</option>
                                <option value="Setrika Saja" {{ old('jenis_layanan') == 'Setrika Saja' ? 'selected' : '' }}>Setrika Saja</option>
                                <option value="Dry Clean" {{ old('jenis_layanan') == 'Dry Clean' ? 'selected' : '' }}>Dry Clean</option>
                            </select>
                            @error('jenis_layanan')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Jumlah Pakaian -->
                        <div>
                            <label for="jumlah_pakaian" class="block text-sm font-medium text-gray-700 mb-2">
                                Jumlah Pakaian (pcs)
                            </label>
                            <input type="number" 
                                   name="jumlah_pakaian" 
                                   id="jumlah_pakaian" 
                                   value="{{ old('jumlah_pakaian') }}"
                                   min="1"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('jumlah_pakaian')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Berat (kg) -->
                        <div>
                            <label for="berat" class="block text-sm font-medium text-gray-700 mb-2">
                                Berat (kg)
                            </label>
                            <input type="number" 
                                   name="berat" 
                                   id="berat" 
                                   value="{{ old('berat') }}"
                                   min="0"
                                   step="0.1"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('berat')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-6">
                        <!-- Harga per KG -->
                        <div>
                            <label for="harga_per_kg" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga per KG (Rp)
                            </label>
                            <input type="number" 
                                   name="harga_per_kg" 
                                   id="harga_per_kg" 
                                   value="{{ old('harga_per_kg', 5000) }}"
                                   min="0"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('harga_per_kg')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Harga -->
                        <div>
                            <label for="total_harga" class="block text-sm font-medium text-gray-700 mb-2">
                                Total Harga (Rp)
                            </label>
                            <input type="number" 
                                   name="total_harga" 
                                   id="total_harga" 
                                   value="{{ old('total_harga') }}"
                                   min="0"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                   required>
                            @error('total_harga')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal Selesai -->
                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Selesai
                            </label>
                            <input type="datetime-local" 
                                   name="tanggal_selesai" 
                                   id="tanggal_selesai" 
                                   value="{{ old('tanggal_selesai') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('tanggal_selesai')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status
                            </label>
                            <select name="status" 
                                    id="status" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required>
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="dalam_proses" {{ old('status') == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="diambil" {{ old('status') == 'diambil' ? 'selected' : '' }}>Diambil</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="mt-6">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan (Opsional)
                    </label>
                    <textarea name="catatan" 
                              id="catatan" 
                              rows="3"
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                              placeholder="Catatan khusus untuk pesanan ini...">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('pesanan.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto calculate total harga
document.addEventListener('DOMContentLoaded', function() {
    const beratInput = document.getElementById('berat');
    const hargaPerKgInput = document.getElementById('harga_per_kg');
    const totalHargaInput = document.getElementById('total_harga');
    const form = document.getElementById('pesananForm');
    
    function calculateTotal() {
        const berat = parseFloat(beratInput.value) || 0;
        const hargaPerKg = parseFloat(hargaPerKgInput.value) || 0;
        const total = berat * hargaPerKg;
        totalHargaInput.value = Math.round(total);
    }
    
    beratInput.addEventListener('input', calculateTotal);
    hargaPerKgInput.addEventListener('input', calculateTotal);
    
    // Handle form submission with CSRF token refresh
    form.addEventListener('submit', function(e) {
        // Update CSRF token before submit
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = form.querySelector('input[name="_token"]');
        if (csrfInput) {
            csrfInput.value = csrfToken;
        }
    });
});
</script>
@endsection
