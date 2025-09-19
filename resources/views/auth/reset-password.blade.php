@extends('layouts.app')

@section('title', 'Reset Password')
@section('page-title', 'Reset Password')
@section('page-description', 'Ubah password akun Anda')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Reset Password</h2>
                    <p class="text-gray-400">Masukkan password lama dan password baru untuk mengubah kata sandi Anda</p>
                </div>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="glass-card rounded-2xl p-6 border border-green-500/30 bg-green-500/10">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-2"></i>
                    <p class="text-green-400">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="glass-card rounded-2xl p-6 border border-red-500/30 bg-red-500/10">
                <div class="flex items-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                    <h3 class="text-red-400 font-semibold">Terdapat kesalahan:</h3>
                </div>
                <ul class="space-y-2">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-300 text-sm flex items-center">
                            <i class="fas fa-dot-circle mr-2 text-xs"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('reset.pw') }}" method="POST" class="glass-card rounded-2xl p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Password Lama -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-yellow-400"></i>
                        Password Lama
                    </label>
                    <div class="relative">
                        <input id="current_password" type="password" name="current_password"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            placeholder="Masukkan password lama" required aria-label="Password Lama">
                        <button type="button" onclick="togglePassword('current_password')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-400">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Baru -->
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-yellow-400"></i>
                        Password Baru
                    </label>
                    <div class="relative">
                        <input id="new_password" type="password" name="new_password"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            placeholder="Masukkan password baru" required aria-label="Password Baru">
                        <button type="button" onclick="togglePassword('new_password')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-400">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('new_password')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Konfirmasi Password Baru -->
                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-lock mr-1 text-yellow-400"></i>
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            placeholder="Konfirmasi password baru" required aria-label="Konfirmasi Password Baru">
                        <button type="button" onclick="togglePassword('new_password_confirmation')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-400">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    @error('new_password_confirmation')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit"
                    class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25"
                    aria-label="Simpan Password">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Password
                </button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection
