@extends('layouts.app')

@section('title', 'Edit Jabatan')
@section('page-title', 'Edit Jabatan')
@section('page-description', 'Edit data jabatan ' . $jabatan->nama_jabatan)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Edit Jabatan: {{ $jabatan->nama_jabatan }}</h2>
                <p class="text-gray-400">Update informasi jabatan</p>
            </div>
            <a href="{{ route('jabatan.view') }}" class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
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
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400/20 to-purple-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-tie text-purple-400"></i>
                    </div>
                    <div>
                        <p class="text-white font-medium">{{ $jabatan->nama_jabatan }}</p>
                        {{-- <p class="text-gray-400 text-sm">{{ $jabatan->staff_count ?? 0 }} Karyawan terdaftar</p> --}}
                    </div>
                </div>
                @if($jabatan->is_active)
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
            Edit Informasi Jabatan
        </h3>

        <form action="{{ route('jabatan.edit', $jabatan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Nama Jabatan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-user-tie mr-1 text-yellow-400"></i>
                    Nama Jabatan
                </label>
                <input type="text" name="nama_jabatan" value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
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
                    <option value="1" {{ old('is_active', $jabatan->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('is_active', $jabatan->is_active) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
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
                    Update Jabatan
                </button>
            </div>
        </form>
    </div>

    <!-- Impact Warning -->
    @if($jabatan->staff_count > 0)
        <div class="glass-card rounded-2xl p-6 border border-yellow-500/30 bg-yellow-500/10">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-yellow-400 mr-3 mt-1"></i>
                <div>
                    <h4 class="text-yellow-400 font-semibold mb-2">Perhatian Perubahan Jabatan</h4>
                    <ul class="text-yellow-300 text-sm space-y-1">
                        <li>• Jabatan ini saat ini digunakan oleh <strong>{{ $jabatan->staff_count }} karyawan</strong></li>
                        <li>• Perubahan nama jabatan akan mempengaruhi semua karyawan yang menggunakan jabatan ini</li>
                        <li>• Jika status diubah menjadi "Tidak Aktif", jabatan tidak akan tersedia untuk karyawan baru</li>
                        <li>• Karyawan yang sudah menggunakan jabatan ini tidak akan terpengaruh</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Related Staff -->
    @if($jabatan->staff_count > 0)
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-users mr-2 text-blue-400"></i>
                Karyawan dengan Jabatan Ini
            </h3>
            <div class="bg-gray-800/30 rounded-lg p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-users text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-white font-medium">{{ $jabatan->staff_count }} Karyawan</p>
                            <p class="text-gray-400 text-sm">Menggunakan jabatan {{ $jabatan->nama_jabatan }}</p>
                        </div>
                    </div>
                    <a href="{{ route('staff.view', ['jabatan_id' => $jabatan->id]) }}"
                       class="inline-flex items-center px-3 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200 border border-blue-500/30">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
