@extends('layouts.app')

@section('title', 'Tambah Cabang')
@section('page-title', 'Tambah Cabang')
@section('page-description', 'Tambah cabang baru ke sistem')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Tambah Cabang Baru</h2>
                    <p class="text-gray-400">Lengkapi form di bawah untuk menambah cabang baru</p>
                </div>
                <a href="{{ route('cabang.view') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-building mr-2 text-yellow-400"></i>
                Informasi Cabang
            </h3>

            <form action="{{ route('cabang.add') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Cabang -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-building mr-1 text-yellow-400"></i>
                        Nama Cabang
                    </label>
                    <input type="text" name="nama_cabang" value="{{ old('nama_cabang') }}"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                        placeholder="Masukkan nama cabang" required>
                    @error('nama_cabang')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-1 text-yellow-400"></i>
                        Alamat
                    </label>
                    <textarea name="alamat" rows="3"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                        placeholder="Masukkan alamat lengkap cabang">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Jam Operasional -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Jam Masuk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-sign-in-alt mr-1 text-green-400"></i>
                            Jam Masuk
                        </label>
                        <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                        @error('jam_masuk')
                            <p class="text-red-400 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Jam Pulang -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-sign-out-alt mr-1 text-red-400"></i>
                            Jam Pulang
                        </label>
                        <input type="time" name="jam_pulang" value="{{ old('jam_pulang') }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                        @error('jam_pulang')
                            <p class="text-red-400 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-toggle-on mr-1 text-yellow-400"></i>
                        Status Aktif
                    </label>
                    <select name="is_active"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                        required>
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
                    <a href="{{ route('cabang.view') }}"
                        class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Cabang
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview Card -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-eye mr-2 text-blue-400"></i>
                Preview Cabang
            </h3>
            <div class="bg-gray-800/30 rounded-lg p-4">
                <div class="flex items-center mb-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-building text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium" id="preview-nama">Nama cabang akan muncul di sini</p>
                        <p class="text-gray-400 text-sm" id="preview-alamat">Alamat akan muncul di sini</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex items-center text-green-400">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        <span class="text-sm">Masuk: <span id="preview-masuk">--:--</span></span>
                    </div>
                    <div class="flex items-center text-red-400">
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        <span class="text-sm">Pulang: <span id="preview-pulang">--:--</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const namaInput = document.querySelector('input[name="nama_cabang"]');
            const alamatInput = document.querySelector('textarea[name="alamat"]');
            const jamMasukInput = document.querySelector('input[name="jam_masuk"]');
            const jamPulangInput = document.querySelector('input[name="jam_pulang"]');

            const previewNama = document.getElementById('preview-nama');
            const previewAlamat = document.getElementById('preview-alamat');
            const previewMasuk = document.getElementById('preview-masuk');
            const previewPulang = document.getElementById('preview-pulang');

            namaInput.addEventListener('input', function() {
                previewNama.textContent = this.value || 'Nama cabang akan muncul di sini';
            });

            alamatInput.addEventListener('input', function() {
                previewAlamat.textContent = this.value || 'Alamat akan muncul di sini';
            });

            jamMasukInput.addEventListener('input', function() {
                previewMasuk.textContent = this.value || '--:--';
            });

            jamPulangInput.addEventListener('input', function() {
                previewPulang.textContent = this.value || '--:--';
            });
        });
    </script>

    <style>
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
    </style>



@endsection
