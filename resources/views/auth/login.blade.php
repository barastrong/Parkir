<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login - Parkir Lokal Station</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans">

    <div class="w-full max-w-sm">
        
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            
            <div class="bg-blue-600 p-6 flex items-center space-x-4">
                <div class="bg-blue-500 p-3 rounded-full shadow-md">
                    <i class="fas fa-lock text-white text-xl"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-xl">Parkir Lokal Station</h1>
                    <p class="text-blue-100 text-sm">Administrator Login</p>
                </div>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username Input - DENGAN STRUKTUR YANG BENAR -->
                    <div>
                        <label for="name" class="text-sm font-semibold text-gray-600">Username</label>
                        <div class="mt-1 flex items-center border border-gray-200 rounded-lg bg-gray-50 focus-within:ring-2 focus-within:ring-blue-500 focus-within:bg-white transition duration-200">
                            <div class="px-3 border-r border-gray-200">
                                <i class="fas fa-user text-blue-500"></i>
                            </div>
                            <input type="text" id="name" name="name" class="w-full bg-transparent p-2 focus:outline-none" placeholder="Masukkan Username" value="{{ old('name') }}" required autofocus>
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input - DENGAN STRUKTUR YANG BENAR -->
                    <div class="mt-4">
                        <label for="password" class="text-sm font-semibold text-gray-600">Password</label>
                        <div class="mt-1 flex items-center border border-gray-200 rounded-lg bg-gray-50 focus-within:ring-2 focus-within:ring-blue-500 focus-within:bg-white transition duration-200">
                            <div class="px-3 border-r border-gray-200">
                                <i class="fas fa-key text-blue-500"></i>
                            </div>
                            <input type="password" id="password" name="password" class="w-full bg-transparent p-2 focus:outline-none" placeholder="Masukkan Password" required>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mt-6">
                        <button type="submit" class="w-full flex items-center justify-center bg-blue-600 text-white font-bold py-2.5 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
                        </button>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center text-sm space-y-4">
                    <div>
                        <p class="text-gray-500">Belum punya akun?</p>
                        <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline flex items-center justify-center mt-1">
                            <i class="fas fa-user-plus mr-2"></i>Daftar disini
                        </a>
                    </div>
                    <div>
                        <a href="{{ url('/') }}" class="text-gray-500 hover:text-blue-600 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Homepage
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <div class="text-center mt-6 text-sm text-gray-500">
            <p>Dikembangkan oleh <a href="#" class="font-semibold text-blue-600 hover:underline">Romi</a></p>
        </div>
    </div>

</body>
</html>