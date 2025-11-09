@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-6 lg:p-8">
    <!-- Header -->
    <div class="text-center mb-6 md:mb-8">
        <h1 class="text-2xl md:text-3xl lg:text-4xl font-bold text-gray-800 px-4">
            Selamat Datang di <span class="text-blue-600">EasyParkir</span>
        </h1>
        <p class="text-gray-500 mt-2 text-sm md:text-base px-4">Sistem parkir digital yang mudah dan efisien</p>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 lg:gap-8">
        
        <!-- Left Section: Parking Statistics -->
        <div class="xl:col-span-2 order-2 xl:order-1">
            <div class="mb-4">
                <h2 class="text-lg md:text-xl font-semibold text-gray-700 mb-4 flex items-center">
                    <i class="fa-solid fa-chart-bar mr-2 text-blue-600"></i>
                    Statistik Parkir
                </h2>
            </div>
            
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-6">
                @forelse ($jenisKendaraanData as $jenis)
                    <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                        <div class="flex justify-between items-center mb-3">
                            <h3 class="font-bold text-base md:text-lg text-gray-700">{{ $jenis->jenis_kendaraan }}</h3>
                            <span class="text-xs md:text-sm font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full whitespace-nowrap">
                                {{ $jenis->kendaraan_masuk_count }}/{{ $jenis->kapasitas_slot }}
                            </span>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-200 rounded-full h-2 md:h-2.5 mb-3">
                            @php
                                $persentase = ($jenis->kapasitas_slot > 0) ? ($jenis->kendaraan_masuk_count / $jenis->kapasitas_slot) * 100 : 0;
                            @endphp
                            <div class="bg-blue-600 h-2 md:h-2.5 rounded-full transition-all duration-300" style="width: {{ $persentase }}%"></div>
                        </div>
                        
                        <div class="flex justify-between items-center text-xs md:text-sm">
                            <span class="text-gray-500">Terisi</span>
                            <span class="font-semibold text-blue-600">
                                {{ $jenis->kapasitas_slot - $jenis->kendaraan_masuk_count }} Tersedia
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="sm:col-span-2 bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                        <i class="fa-solid fa-info-circle text-3xl text-gray-300 mb-2"></i>
                        <p>Belum ada jenis kendaraan yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Right Section: Tariff Check -->
        <div class="xl:row-span-2 order-1 xl:order-2">
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-sm border border-gray-100 sticky top-20">
                <h3 class="font-bold text-lg md:text-xl text-gray-700 mb-4 flex items-center">
                    <i class="fa-solid fa-file-invoice-dollar mr-3 text-blue-600"></i>
                    Cek Tarif Parkir
                </h3>
                
                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="kode_unik" class="block text-sm font-medium text-gray-600 mb-2">
                            Masukkan Kode Unik
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-ticket text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   id="kode_unik" 
                                   name="kode_unik" 
                                   class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-sm md:text-base" 
                                   placeholder="PKR-1234">
                        </div>
                    </div>
                    
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white font-bold py-2.5 px-4 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 flex items-center justify-center text-sm md:text-base">
                        <i class="fa-solid fa-calculator mr-2"></i>
                        Hitung Tarif
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center">
                        <span class="bg-white px-2 text-sm text-gray-500">atau</span>
                    </div>
                </div>
                
                <button class="w-full bg-white text-blue-600 font-bold py-2.5 px-4 rounded-md border-2 border-blue-600 hover:bg-blue-50 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 flex items-center justify-center text-sm md:text-base">
                    <i class="fa-solid fa-qrcode mr-2"></i>
                    Scan QR Code
                </button>
                
                <p class="text-xs text-gray-500 text-center mt-3 leading-relaxed">
                    Arahkan kamera ke QR Code untuk memeriksa tarif parkir
                </p>
            </div>
        </div>
    </div>

    <!-- Parking Vehicles Table -->
    <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 md:p-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 border-b border-gray-200 bg-gray-50">
            <h3 class="font-bold text-lg md:text-xl text-gray-700 flex items-center">
                <i class="fa-solid fa-car-on mr-3 text-blue-600"></i>
                Kendaraan Parkir
            </h3>
            <span class="bg-blue-600 text-white text-xs md:text-sm font-semibold px-3 py-2 rounded-full self-start sm:self-center">
                Total: {{ $totalKendaraan }} kendaraan
            </span>
        </div>
        
        <!-- Mobile Card View -->
        <div class="block md:hidden">
            @forelse ($kendaraanParkir as $kendaraan)
                <div class="p-4 border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 text-sm">{{ $kendaraan->nama_kendaraan }}</h4>
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded-full mt-1">
                                {{ $kendaraan->nama_jenis_kendaraan }}
                            </span>
                        </div>
                        <span class="text-xs text-gray-500 font-medium">
                            #{{ $loop->iteration + ($kendaraanParkir->currentPage() - 1) * $kendaraanParkir->perPage() }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mt-3">
                        <div>
                            <span class="text-gray-500">Waktu Masuk:</span>
                            <div class="font-medium">{{ \Carbon\Carbon::parse($kendaraan->waktu_masuk)->format('d/m/Y H:i') }}</div>
                        </div>
                        <div>
                            <span class="text-gray-500">Durasi:</span>
                            <div class="font-medium">{{ $kendaraan->durasi_parkir }}</div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <i class="fa-solid fa-car text-4xl text-gray-300 mb-3"></i>
                    <p>Tidak ada kendaraan yang sedang parkir.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Desktop Table View -->
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Nama Kendaraan</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Jenis</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Waktu Masuk</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Durasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kendaraanParkir as $kendaraan)
                        <tr class="bg-white border-b hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-medium">
                                {{ $loop->iteration + ($kendaraanParkir->currentPage() - 1) * $kendaraanParkir->perPage() }}
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $kendaraan->nama_kendaraan }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $kendaraan->nama_jenis_kendaraan }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($kendaraan->waktu_masuk)->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 font-medium">{{ $kendaraan->durasi_parkir }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-500">
                                <i class="fa-solid fa-car text-4xl text-gray-300 mb-3"></i>
                                <p>Tidak ada kendaraan yang sedang parkir.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($kendaraanParkir->hasPages())
            <div class="p-4 md:p-6 border-t border-gray-200 bg-gray-50">
                <div class="flex justify-center">
                    {{ $kendaraanParkir->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Custom Styles for Better Mobile Experience -->
<style>
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
    
    /* Improve pagination on mobile */
    .pagination {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    
    .pagination .page-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    @media (max-width: 640px) {
        .pagination .page-link {
            padding: 0.375rem 0.625rem;
            font-size: 0.8125rem;
        }
    }
</style>

@endsection