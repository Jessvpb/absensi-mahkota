@extends('layouts.app')

@section('title', $user ? 'Edit Akun' : 'Buat Akun')
@section('page-title', $user ? 'Edit Akun' : 'Buat Akun')
@section('page-description', ($user ? 'Edit akun' : 'Buat akun baru') . ' untuk ' . $staff->nama)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">
                    {{ $user ? 'Edit Akun' : 'Buat Akun' }} untuk {{ $staff->nama }}
                </h2>
                <p class="text-gray-400">
                    {{ $user ? 'Update informasi akun pengguna' : 'Buat akun baru untuk karyawan' }}
                </p>
            </div>
            <a href="{{ route('staff.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Staff Info -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-user mr-2 text-yellow-400"></i>
            Informasi Karyawan
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-user text-yellow-400"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">Nama</p>
                    <p class="text-white font-medium">{{ $staff->nama }}</p>
                </div>
            </div>
            <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-id-card text-blue-400"></i>
                </div>
                <div>
                    <p class="text-gray-400 text-sm">NIP</p>
                    <p class="text-white font-medium">{{ $staff->NIP }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Form -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-6 flex items-center">
            <i class="fas fa-user-cog mr-2 text-yellow-400"></i>
            {{ $user ? 'Edit Akun' : 'Buat Akun Baru' }}
        </h3>

        <form action="{{ route('staff.saveUser', $staff->id) }}" method="POST" autocomplete="off" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-envelope mr-1 text-yellow-400"></i>
                    Email
                </label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                       autocomplete="new-email"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                       placeholder="Masukkan email" required>
                @error('email')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-lock mr-1 text-yellow-400"></i>
                    Password
                    @if($user)
                        <span class="text-gray-500 text-xs">(biarkan kosong jika tidak ingin mengganti)</span>
                    @endif
                </label>
                <div class="relative">
                    <input type="password" name="password"
                           autocomplete="new-password"
                           class="w-full px-4 py-3 pr-12 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="{{ $user ? 'Masukkan password baru' : 'Masukkan password' }}" {{ $user ? '' : 'required' }}>
                    <button type="button" onclick="togglePassword('password')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-400 transition-colors">
                        <i class="fas fa-eye" id="password-eye"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-lock mr-1 text-yellow-400"></i>
                    Konfirmasi Password
                </label>
                <div class="relative">
                    <input type="password" name="password_confirmation"
                           class="w-full px-4 py-3 pr-12 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Konfirmasi password">
                    <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-yellow-400 transition-colors">
                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Role -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user-tag mr-1 text-yellow-400"></i>
                    Role
                </label>
                <select name="role" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                    @foreach (['admin', 'karyawan', 'kepala'] as $role)
                        <option value="{{ $role }}" {{ (old('role', $user->role ?? '') == $role) ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                    @endforeach
                </select>
                @error('role')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('staff.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-save mr-2"></i>
                    {{ $user ? 'Update Akun' : 'Simpan Akun' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldName) {
    const field = document.querySelector(`input[name="${fieldName}"]`);
    const eye = document.getElementById(`${fieldName}-eye`);

    if (field.type === 'password') {
        field.type = 'text';
        eye.classList.remove('fa-eye');
        eye.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        eye.classList.remove('fa-eye-slash');
        eye.classList.add('fa-eye');
    }
}
</script>
@endsection
