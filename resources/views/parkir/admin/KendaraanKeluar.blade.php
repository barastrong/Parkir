@extends('layouts.sidebar')

@section('content')
    <div class="container-fluid py-6">
        <div class="row">
            <div class="col-12">
                <!-- Breadcrumb -->
                <nav class="flex mb-5" aria-label="breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ url('/dashboard') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                                Dashboard
                            </a>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-500">Kendaraan Keluar</span>
                            </div>
                        </li>
                    </ol>
                </nav>

                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                        <i class="fas fa-car-side mr-3 text-blue-600"></i>
                        Konfirmasi Kendaraan Keluar
                    </h1>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4 flex items-center" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                        <button type="button" class="ml-auto text-green-500 hover:text-green-700" onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-4 flex items-center" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                        <button type="button" class="ml-auto text-red-500 hover:text-red-700" onclick="this.parentElement.style.display='none'">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Scan/Input Section -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-qrcode mr-3 text-blue-600"></i>
                                Scan/Masukkan Kode
                            </h4>
                            
                            <form action="{{ route('riwayatkeluar.store') }}" method="POST" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="kode_unik" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode Unik Kendaraan
                                    </label>
                                    <input type="text" 
                                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 text-lg" 
                                           id="kode_unik" 
                                           name="kode_unik" 
                                           placeholder="Masukkan kode unik" 
                                           required 
                                           autofocus>
                                </div>
                                    <button type="submit" 
                                        class="w-full bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl hover:bg-blue-800 hover:-translate-y-1 tr hover:shadow-2xl transform transition-all duration-300">
                                        <i class="fas fa-qrcode mr-2"></i>
                                        Scan QR Code
                                    </button>
                            </form>
                        </div>
                    </div>

                    <!-- History Section -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-2xl shadow-lg p-8">
                            <h4 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-history mr-3 text-blue-600"></i>
                                Riwayat Keluar
                            </h4>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full table-auto">
                                    <thead>
                                        <tr class="bg-blue-600 text-white">
                                            <th class="px-6 py-4 text-center font-semibold rounded-tl-xl">KODE</th>
                                            <th class="px-6 py-4 text-center font-semibold">KENDARAAN</th>
                                            <th class="px-6 py-4 text-center font-semibold">WAKTU</th>
                                            <th class="px-6 py-4 text-center font-semibold rounded-tr-xl">BIAYA</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @forelse($riwayatKeluar as $item)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 text-center">
                                                    <span class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                        {{ $item->kode_unik }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div>
                                                        <div class="font-semibold text-gray-800">{{ $item->nama_kendaraan }}</div>
                                                        <div class="text-sm text-gray-500">{{ $item->jenisKendaraan->jenis_kendaraan ?? 'N/A' }}</div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="text-sm text-gray-600">
                                                        {{ \Carbon\Carbon::parse($item->waktu_keluar)->format('d/m/Y H:i') }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-center">
                                                    <span class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-3 py-1 rounded-full text-sm font-medium">
                                                        Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                                    <div class="flex flex-col items-center">
                                                        <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                                        <p class="text-lg">Belum ada riwayat kendaraan keluar</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($riwayatKeluar->hasPages())
                                <div class="flex justify-center mt-6">
                                    <nav class="flex items-center space-x-2">
                                        {{ $riwayatKeluar->links('pagination::tailwind') }}
                                    </nav>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto focus on input when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('kode_unik');
            if (input) {
                input.focus();
            }
        });

        // Auto submit form when QR code is scanned (optional)
        document.getElementById('kode_unik').addEventListener('input', function() {
            if (this.value.length >= 8) { // Adjust length as needed
                // Optional: Auto submit after a short delay
                // setTimeout(() => {
                //     this.form.submit();
                // }, 500);
            }
        });
    </script>
@endsection