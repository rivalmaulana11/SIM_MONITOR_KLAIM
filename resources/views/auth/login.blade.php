<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Monitoring Klaim RSKK</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="bg-blue-600 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-800">Sistem Monitoring Klaim</h1>
                <p class="text-gray-600 mt-2">RSKK - Rumah Sakit Kesehatan Kerja Provinsi Jawa Barat</p>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Username -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                    <input 
                        type="text" 
                        name="username" 
                        id="username" 
                        value="{{ old('username') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan username"
                        required
                        autofocus
                    >
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-6">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                    >
                    <label for="remember" class="ml-2 text-gray-700 text-sm">Ingat saya</label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 shadow-lg hover:shadow-xl"
                >
                    Masuk
                </button>
            </form>

            {{-- <!-- Info Akun Default -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 text-center mb-3">Akun Default:</p>
                <div class="space-y-2 text-xs text-gray-600">
                    <div class="flex justify-between bg-gray-50 p-2 rounded">
                        <span class="font-medium">Super Admin:</span>
                        <span>admin / admin123</span>
                    </div>
                    <div class="flex justify-between bg-gray-50 p-2 rounded">
                        <span class="font-medium">Casemix:</span>
                        <span>casemix / casemix123</span>
                    </div>
                    <div class="flex justify-between bg-gray-50 p-2 rounded">
                        <span class="font-medium">Keuangan:</span>
                        <span>keuangan / keuangan123</span>
                    </div>
                </div>
            </div> --}}
        </div>

        <p class="text-center text-gray-600 text-sm mt-6">
            © 2025 RSKK. All rights reserved.
        </p>
    </div>
</body>
</html>