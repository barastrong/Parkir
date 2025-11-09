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

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h2 class="text-2xl font-semibold text-gray-800">Manajemen User</h2>
            <nav class="text-sm text-gray-500" aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center">
                    <li><a href="{{ route('parkir.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-500">Manajemen User</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
            <h3 class="text-lg font-semibold text-gray-700">Daftar User</h3>
            @if(Auth::user()->role === 'admin')
                <button @click="addModalOpen = true" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center shadow-md w-full sm:w-auto justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah User
                </button>
            @endif
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

        @if (session('error'))
            <div 
                x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 flex justify-between items-center" 
                role="alert"
            >
                <p class="font-medium">{{ session('error') }}</p>
                <button @click="show = false" class="text-red-700 hover:text-red-900">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-3 sm:px-6 py-3">No</th>
                        <th scope="col" class="px-3 sm:px-6 py-3">Username</th>
                        <th scope="col" class="px-3 sm:px-6 py-3">Role</th>
                        <th scope="col" class="px-3 sm:px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-3 sm:px-6 py-4 font-medium">{{ $users->firstItem() + $index }}</td>
                            <td class="px-3 sm:px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-3 sm:px-6 py-4">
                                @if ($user->role == 'admin')
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Admin
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Petugas
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 sm:px-6 py-4 text-center">
                                @if(Auth::id() === $user->id)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Login Aktif
                                    </span>
                                @else
                                    @if(Auth::user()->role === 'admin')
                                        <div class="flex justify-center space-x-1 sm:space-x-2">
                                            <button @click="editModalOpen = true; formData = {id: {{ $user->id }}, name: '{{ $user->name }}', role: '{{ $user->role }}'}; formAction = '{{ route('users.update', $user->id) }}'" class="p-2 bg-blue-100 rounded-md hover:bg-blue-200 transition-colors">
                                                <i class="fas fa-pencil-alt text-blue-600"></i>
                                            </button>
                                            <button @click="deleteModalOpen = true; deleteAction = '{{ route('users.destroy', $user->id) }}'" class="p-2 bg-red-100 rounded-md hover:bg-red-200 transition-colors">
                                                <i class="fas fa-trash-alt text-red-600"></i>
                                            </button>
                                        </div>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Tidak Ada Akses
                                        </span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-300 mb-2"></i>
                                    <p class="text-sm">Tidak ada data user.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    <!-- Modal Tambah User -->
    <div x-show="addModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="addModalOpen" @click="addModalOpen = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div x-show="addModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg p-6 text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Tambah User Baru</h3>
                    <button @click="addModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <hr class="my-4">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="add_name" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="name" id="add_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="add_password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="add_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                            <p class="mt-1 text-xs text-gray-500">Password minimal 8 karakter.</p>
                        </div>
                        <div>
                            <label for="add_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="add_password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="radio" name="role" value="admin" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Admin</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="radio" name="role" value="pegawai" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                    <span class="ml-2 text-sm font-medium text-gray-700">Petugas</span>
                                </label>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Default: Petugas</p>
                        </div>
                    </div>
                    <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <button type="button" @click="addModalOpen = false" class="w-full sm:w-auto bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="editModalOpen" @click="editModalOpen = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block w-full max-w-lg p-6 text-left align-middle transition-all transform bg-white shadow-xl rounded-lg">
                <div class="flex items-start justify-between">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Edit User</h3>
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
                            <label for="edit_name" class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" name="name" id="edit_name" x-model="formData.name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="edit_password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" name="password" id="edit_password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengubah password.</p>
                        </div>
                        <div>
                            <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="edit_password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label for="edit_role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="radio" name="role" value="admin" x-model="formData.role" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Admin</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors">
                                    <input type="radio" name="role" value="pegawai" x-model="formData.role" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span class="ml-2 text-sm font-medium text-gray-700">Petugas</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                        <button type="button" @click="editModalOpen = false" class="w-full sm:w-auto bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300 transition duration-300">Batal</button>
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete User -->
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
         <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="deleteModalOpen" @click="deleteModalOpen = false" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
            <div x-show="deleteModalOpen" x-transition class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-auto z-10">
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                    <p class="mt-2 text-sm text-gray-500">Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <form :action="deleteAction" method="POST" class="mt-6 flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-3">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModalOpen = false" class="w-full sm:w-auto bg-gray-200 text-gray-800 font-semibold py-2 px-4 rounded-lg hover:bg-gray-300">Batal</button>
                    <button type="submit" class="w-full sm:w-auto bg-red-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-700">Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection