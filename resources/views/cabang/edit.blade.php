@extends('layouts.app')

@section('title', 'Edit Cabang')
@section('page-title', 'Edit Cabang')
@section('page-description', 'Edit data cabang ' . $cabang->nama_cabang)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Edit Cabang: {{ $cabang->nama_cabang }}</h2>
                <p class="text-gray-400">Update informasi cabang dan jam operasional</p>
            </div>
            <a href="{{ route('cabang.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Current Info -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-blue-400"></i>
            Informasi Saat Ini
        </h3>
        <div class="bg-gray-800/30 rounded-lg p-4">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-4">
                    <i class="fas fa-building text-blue-400"></i>
                </div>
                <div>
                    <p class="text-white font-medium">{{ $cabang->nama_cabang }}</p>
                    <p class="text-gray-400 text-sm">{{ $cabang->alamat ?? 'Alamat tidak tersedia' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="flex items-center text-green-400">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    <span class="text-sm">Masuk: {{ \Carbon\Carbon::parse($cabang->jam_masuk)->format('H:i') }}</span>
                </div>
                <div class="flex items-center text-red-400">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span class="text-sm">Pulang: {{ \Carbon\Carbon::parse($cabang->jam_pulang)->format('H:i') }}</span>
                </div>
            </div>
            <div class="mt-3">
                @if($cabang->is_active)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                        <i class="fas fa-check-circle mr-1"></i>
                        Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                        <i class="fas fa-times-circle mr-1"></i>
                        Tidak Aktif
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
            <i class="fas fa-edit mr-2 text-yellow-400"></i>
            Edit Informasi Cabang
        </h3>

        <form action="{{ route('cabang.edit', $cabang->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Nama Cabang -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-building mr-1 text-yellow-400"></i>
                    Nama Cabang
                </label>
                <input type="text" name="nama_cabang" value="{{ old('nama_cabang', $cabang->nama_cabang) }}"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
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
                          placeholder="Masukkan alamat lengkap cabang">{{ old('alamat', $cabang->alamat) }}</textarea>
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
                    <input type="time" name="jam_masuk" value="{{ old('jam_masuk', \Carbon\Carbon::parse($cabang->jam_masuk)->format('H:i')) }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
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
                    <input type="time" name="jam_pulang" value="{{ old('jam_pulang', \Carbon\Carbon::parse($cabang->jam_pulang)->format('H:i')) }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
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
                <select name="is_active" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                    <option value="1" {{ old('is_active', $cabang->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $cabang->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
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
                <a href="{{ route('cabang.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-save mr-2"></i>
                    Update Cabang
                </button>
            </div>
        </form>
    </div>

    <!-- Time Validation Warning -->
    <div class="glass-card rounded-2xl p-6 border border-yellow-500/30 bg-yellow-500/10">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
            <div>
                <h4 class="text-yellow-400 font-semibold mb-2">Perhatian Jam Operasional</h4>
                <ul class="text-yellow-300 text-sm space-y-1">
                    <li>• Pastikan jam masuk lebih awal dari jam pulang</li>
                    <li>• Jam operasional akan mempengaruhi sistem absensi karyawan</li>
                    <li>• Perubahan jam operasional akan berlaku untuk semua karyawan di cabang ini</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const jamMasukInput = document.querySelector('input[name="jam_masuk"]');
    const jamPulangInput = document.querySelector('input[name="jam_pulang"]');

    function validateTime() {
        if (jamMasukInput.value && jamPulangInput.value) {
            const masuk = new Date('2000-01-01 ' + jamMasukInput.value);
            const pulang = new Date('2000-01-01 ' + jamPulangInput.value);

            if (masuk >= pulang) {
                jamPulangInput.setCustomValidity('Jam pulang harus lebih lambat dari jam masuk');
            } else {
                jamPulangInput.setCustomValidity('');
            }
        }
    }

    jamMasukInput.addEventListener('change', validateTime);
    jamPulangInput.addEventListener('change', validateTime);
});
</script>
@endsection
