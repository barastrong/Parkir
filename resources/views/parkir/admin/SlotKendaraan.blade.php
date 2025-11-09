@extends('layouts.sidebar')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Slot Parkir</h1>
            <nav class="text-sm text-gray-600 mt-1">
                <a href="{{ route('parkir.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
                <span class="mx-1">/</span>
                <span>Slot Parkir</span>
            </nav>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 font-medium text-gray-600 uppercase tracking-wider text-sm">
                                JENIS KENDARAAN
                            </th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 uppercase tracking-wider text-sm">
                                KAPASITAS
                            </th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 uppercase tracking-wider text-sm">
                                TERPARKIR
                            </th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 uppercase tracking-wider text-sm">
                                SISA SLOT
                            </th>
                            <th class="text-left py-3 px-4 font-medium text-gray-600 uppercase tracking-wider text-sm">
                                UBAH KAPASITAS
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($jenisKendaraans as $jenis)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-4">
                                    <div class="font-medium text-gray-900">{{ $jenis->jenis_kendaraan }}</div>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="text-gray-900">{{ $jenis->kapasitas_slot }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    @php
                                        $jumlahTerparkir = $terparkir[$jenis->id] ?? 0;
                                        $sisaSlot = $jenis->kapasitas_slot - $jumlahTerparkir;
                                    @endphp
                                    <span class="text-gray-900">{{ $jumlahTerparkir }}</span>
                                </td>
                                <td class="py-4 px-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $sisaSlot > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $sisaSlot }}
                                    </span>
                                </td>
                                <td class="py-4 px-4">
                                    <form action="{{ route('parkir.slotStore') }}" method="POST" class="flex items-center space-x-2">
                                        @csrf
                                        <input type="hidden" name="id_jeniskendaraan" value="{{ $jenis->id }}">
                                        <input type="number" 
                                               name="kapasitas_slot" 
                                               value="{{ $jenis->kapasitas_slot }}"
                                               class="w-20 px-2 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                               min="0" 
                                               required>
                                        <button type="submit" 
                                                class="bg-blue-600 text-white px-3 py-1 rounded-md text-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Update
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Button Simpan Perubahan -->
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 rounded-b-lg">
            <button onclick="submitAllChanges()" 
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center space-x-2">
                <i class="fas fa-save"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>
</div>

<script>
function submitAllChanges() {
    // Implementasi untuk submit semua perubahan sekaligus jika diperlukan
    alert('Untuk mengubah kapasitas, gunakan tombol Update pada setiap baris.');
}
</script>
@endsection