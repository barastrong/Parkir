@extends('layouts.sidebar')

@section('content')

<div 
    x-data="{ qrModalOpen: {{ session('qrCode') ? 'true' : 'false' }} }"
    class="bg-gray-50 min-h-screen"
>
    <div class="p-4 sm:p-6 lg:p-8">
        
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center space-x-3 mb-2">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tambah Kendaraan Masuk</h1>
            </div>
            <div class="text-sm text-gray-600">
                <a href="#" class="text-blue-600 hover:underline">Dashboard</a>
                <span class="mx-2">/</span>
                <span>Kendaraan Masuk</span>
            </div>
        </div>

        <!-- Notifikasi -->
        @if (session('success') && !session('qrCode'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded-r-lg" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        @if (session('error'))
             <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded-r-lg" role="alert">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Form Input Kendaraan -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Form Input Kendaraan</h2>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('kendaraanmasuk.store') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Nama Kendaraan -->
                            <div>
                                <label for="nama_kendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Kendaraan
                                </label>
                                <input 
                                    type="text" 
                                    name="nama_kendaraan" 
                                    id="nama_kendaraan" 
                                    value="{{ old('nama_kendaraan') }}" 
                                    placeholder="Contoh: Honda Vario 125 atau B 1234 ABC" 
                                    required 
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                >
                                @error('nama_kendaraan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Jenis Kendaraan -->
                            <div>
                                <label for="id_jeniskendaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Kendaraan
                                </label>
                                <select 
                                    name="id_jeniskendaraan" 
                                    id="id_jeniskendaraan" 
                                    required 
                                    class="block w-full px-4 py-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                >
                                    <option value="" disabled selected>-- Pilih Jenis Kendaraan --</option>
                                    @foreach ($jenisKendaraans as $jenis)
                                        <option value="{{ $jenis->id }}" {{ old('id_jeniskendaraan') == $jenis->id ? 'selected' : '' }}>
                                            {{ $jenis->jenis_kendaraan }} - Rp. {{ number_format($jenis->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_jeniskendaraan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Submit Button -->
                            <div>
                                <button 
                                    type="submit" 
                                    class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 flex items-center justify-center space-x-2 shadow-sm"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    <span>Simpan & Generate QR</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informasi Slot Parkir -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h2 class="text-lg font-semibold text-gray-900">Informasi Slot Parkir</h2>
                    </div>
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="border-b border-gray-200">
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kendaraan</th>
                                        <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Kapasitas</th>
                                        <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Terparkir</th>
                                        <th class="px-2 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Slot</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($jenisKendaraans as $jenis)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-2 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $jenis->jenis_kendaraan }}</td>
                                            <td class="px-2 py-3 whitespace-nowrap text-sm text-center text-gray-600">{{ $jenis->kapasitas_slot }}</td>
                                            <td class="px-2 py-3 whitespace-nowrap text-sm text-center text-gray-600">{{ $jenis->terparkir }}</td>
                                            <td class="px-2 py-3 whitespace-nowrap text-sm text-center font-bold {{ $jenis->sisa_slot > 0 ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $jenis->sisa_slot }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Kendaraan Masuk -->
        <div class="mt-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Riwayat Kendaraan Masuk Anda</span>
                    </h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Unik</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kendaraan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($riwayatMasuk as $riwayat)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $riwayat->kode_unik }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $riwayat->nama_kendaraan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $riwayat->jenisKendaraan->jenis_kendaraan }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ \Carbon\Carbon::parse($riwayat->waktu_masuk)->format('d M Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                        <div class="flex flex-col items-center space-y-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-sm">Belum ada riwayat kendaraan masuk</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    @if (session('qrCode'))
    <div
        x-show="qrModalOpen"
        x-cloak
        class="fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
        @keydown.escape.window="qrModalOpen = false"
    >
        <div class="relative mx-auto border w-full max-w-md shadow-xl rounded-2xl bg-white text-center transform transition-all" @click.away="qrModalOpen = false">
            <div class="p-6">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Tiket Parkir Berhasil Dibuat!</h3>
                <p class="text-sm text-gray-600 mb-6">Silakan scan QR Code di bawah ini untuk masuk ke area parkir</p>
                
                <div class="flex flex-col items-center space-y-4">
                    <div class="p-2 border rounded-lg">
                        <img src="{{ session('qrCode') }}" alt="QR Code Tiket">
                    </div>
                    <div class="text-center">
                        <p class="text-xs text-gray-500 mb-1">Kode Unik</p>
                        <p class="text-lg font-bold tracking-widest text-gray-900 bg-gray-100 px-4 py-2 rounded-lg">{{ session('kodeUnik') }}</p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-center space-x-3">
                    <button 
                        @click="qrModalOpen = false" 
                        class="px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors duration-200"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection