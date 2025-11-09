@extends('layouts.sidebar')

@section('content')

<div 
    x-data="{ 
        addModalOpen: false, 
        editModalOpen: false, 
        deleteModalOpen: false,
        formData: {},
        formAction: '',
        deleteAction: ''
    }" 
    class="space-y-6"
>

    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800">Jenis Kendaraan</h2>
            <nav class="text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center">
                    <li><a href="{{ route('parkir.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-500">Jenis Kendaraan</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-700">Daftar Jenis Kendaraan</h3>
            <button @click="addModalOpen = true" class="bg-blue-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center shadow-md">
                <i class="fas fa-plus mr-2"></i>
                Tambah Jenis
            </button>
        </div>

        @if (session('success'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 flex justify-between items-center" 
                role="alert"
            >
                <p class="font-medium">{{ session('success') }}</p>
                <button @click="show = false" class="text-green-700 hover:text-green-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Jenis Kendaraan</th>
                        <th scope="col" class="px-6 py-3">Harga</th>
                        <th scope="col" class="px-6 py-3">Kapasitas Slot</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $item)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $item->jenis_kendaraan }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $item->kapasitas_slot }} slot</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center space-x-2">
                                    <button @click="editModalOpen = true; formData = {{ $item }}; formAction = '{{ route('parkir.jenis-kendaraan.update', $item->id) }}' " class="p-2 bg-blue-100 rounded-md hover:bg-blue-200 transition-colors">
                                        <i class="fas fa-pencil-alt text-blue-600"></i>
                                    </button>
                                    <button @click="deleteModalOpen = true; deleteAction = '{{ route('parkir.jenis-kendaraan.destroy', $item->id) }}' " class="p-2 bg-red-100 rounded-md hover:bg-red-200 transition-colors">
                                        <i class="fas fa-trash-alt text-red-600"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Tidak ada data jenis kendaraan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="addModalOpen" @click="addModalOpen = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div x-show="addModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg p-6 text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Tambah Jenis Kendaraan</h3>
                    <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <hr class="my-4">
                <form action="{{ route('parkir.jenis-kendaraan.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="add_jenis_kendaraan" class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                            <input type="text" name="jenis_kendaraan" id="add_jenis_kendaraan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="add_harga" class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="harga" id="add_harga" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="add_kapasitas_slot" class="block text-sm font-medium text-gray-700">Kapasitas Slot</label>
                            <input type="number" name="kapasitas_slot" id="add_kapasitas_slot" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="addModalOpen = false" class="bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="editModalOpen" @click="editModalOpen = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg p-6 text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Edit Jenis Kendaraan</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <hr class="my-4">
                <form :action="formAction" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label for="edit_jenis_kendaraan" class="block text-sm font-medium text-gray-700">Jenis Kendaraan</label>
                            <input type="text" name="jenis_kendaraan" id="edit_jenis_kendaraan" x-model="formData.jenis_kendaraan" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="edit_harga" class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="harga" id="edit_harga" x-model="formData.harga" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="edit_kapasitas_slot" class="block text-sm font-medium text-gray-700">Kapasitas Slot</label>
                            <input type="number" name="kapasitas_slot" id="edit_kapasitas_slot" x-model="formData.kapasitas_slot" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-3">
                        <button type="button" @click="editModalOpen = false" class="bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                        <button type="submit" class="bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
         <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="deleteModalOpen" @click="deleteModalOpen = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            <div x-show="deleteModalOpen" x-transition class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto z-10">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                    <p class="mt-2 text-sm text-gray-500">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <form :action="deleteAction" method="POST" class="mt-6 flex justify-center space-x-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModalOpen = false" class="w-full bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="w-full bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection