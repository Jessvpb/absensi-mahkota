@extends('layouts.app')

@section('title', 'Tambah Jabatan')
@section('page-title', 'Tambah Jabatan')
@section('page-description', 'Tambah jabatan baru ke sistem')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Tambah Jabatan Baru</h2>
                <p class="text-gray-400">Lengkapi form di bawah untuk menambah jabatan baru</p>
            </div>
            <a href="{{ route('jabatan.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
            <i class="fas fa-user-tie mr-2 text-yellow-400"></i>
            Informasi Jabatan
        </h3>

        <form action="{{ route('jabatan.add') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama Jabatan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user-tie mr-1 text-yellow-400"></i>
                    Nama Jabatan
                </label>
                <input type="text" name="nama_jabatan" value="{{ old('nama_jabatan') }}"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                       placeholder="Masukkan nama jabatan (contoh: Manager, Supervisor, Staff)" required>
                @error('nama_jabatan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-toggle-on mr-1 text-yellow-400"></i>
                    Status Aktif
                </label>
                <select name="is_active" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('is_active')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('jabatan.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Jabatan
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Card -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-eye mr-2 text-blue-400"></i>
            Preview Jabatan
        </h3>
        <div class="bg-gray-800/30 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400/20 to-purple-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-tie text-purple-400"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium" id="preview-nama">Nama jabatan akan muncul di sini</p>
                        <p class="text-gray-400 text-sm">Jabatan baru</p>
                    </div>
                </div>
                <span id="preview-status" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                    <i class="fas fa-check-circle mr-1"></i>
                    Aktif
                </span>
            </div>
        </div>
    </div>

    <!-- Common Positions -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-lightbulb mr-2 text-yellow-400"></i>
            Contoh Jabatan Umum
        </h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
            @php
                $commonPositions = [
                    'Manager', 'Supervisor', 'Staff', 'Kasir', 'Sales', 'Admin',
                    'Security', 'Cleaning Service', 'Driver', 'Teknisi', 'Customer Service', 'Marketing'
                ];
            @endphp
            @foreach($commonPositions as $position)
                <button type="button" onclick="fillPosition('{{ $position }}')"
                        class="text-left p-3 bg-gray-800/30 rounded-lg border border-gray-700/50 hover:border-yellow-400/30 hover:bg-gray-800/50 transition-all duration-200 text-gray-300 hover:text-white">
                    <i class="fas fa-user-tie mr-2 text-purple-400"></i>
                    {{ $position }}
                </button>
            @endforeach
        </div>
        <p class="text-gray-500 text-sm mt-3">
            <i class="fas fa-info-circle mr-1"></i>
            Klik salah satu contoh di atas untuk mengisi form dengan cepat
        </p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaInput = document.querySelector('input[name="nama_jabatan"]');
    const statusSelect = document.querySelector('select[name="is_active"]');
    const previewNama = document.getElementById('preview-nama');
    const previewStatus = document.getElementById('preview-status');

    namaInput.addEventListener('input', function() {
        previewNama.textContent = this.value || 'Nama jabatan akan muncul di sini';
    });

    statusSelect.addEventListener('change', function() {
        if (this.value === '1') {
            previewStatus.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Aktif';
            previewStatus.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30';
        } else {
            previewStatus.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Tidak Aktif';
            previewStatus.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30';
        }
    });
});

function fillPosition(position) {
    document.querySelector('input[name="nama_jabatan"]').value = position;
    document.getElementById('preview-nama').textContent = position;
}
</script>
@endsection
