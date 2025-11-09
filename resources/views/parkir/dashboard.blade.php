@extends('layouts.sidebar')

@section('content')
<div class="space-y-8">
    
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-700 flex items-center">
            <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i>
            Dashboard
        </h2>
    </div>

    {{-- Kartu Ucapan Selamat Datang --}}
    <div class="bg-white rounded-lg shadow-sm p-6 flex justify-between items-center">
        <div>
            <h3 class="text-xl font-semibold text-gray-800">
                Selamat datang, <span class="text-blue-600">{{ $user->name ?? 'Pengguna' }}</span>!
            </h3>
            <p class="text-sm text-gray-500 mt-1">
                Sistem parkir sudah aktif. Gunakan menu sidebar untuk navigasi fitur.
            </p>
        </div>
        <div>
            <i class="fas fa-car-side fa-3x text-blue-500 opacity-75"></i>
        </div>
    </div>

    {{-- Grid Statistik Parkir --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($jenisKendaraanData as $jenis)
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex justify-between items-center mb-2">
                    <h3 class="font-bold text-lg text-gray-700">{{ $jenis->jenis_kendaraan }}</h3>
                    <span class="text-sm font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">{{ $jenis->kendaraan_masuk_count }}/{{ $jenis->kapasitas_slot }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                    @php
                        $tersedia = $jenis->kapasitas_slot - $jenis->kendaraan_masuk_count;
                        $persentase = ($jenis->kapasitas_slot > 0) ? ($jenis->kendaraan_masuk_count / $jenis->kapasitas_slot) * 100 : 0;
                    @endphp
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $persentase }}%"></div>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Terisi</span>
                    <span class="font-semibold text-blue-600">{{ $tersedia }} Slot Tersedia</span>
                </div>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 bg-white p-6 rounded-lg shadow-sm text-center text-gray-500">
                Belum ada jenis kendaraan yang dikonfigurasi.
            </div>
        @endforelse
    </div>
</div>
@endsection