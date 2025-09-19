@extends('layouts.app')

@section('title', 'Import Data Absen')
@section('page-title', 'Import Data Absen')
@section('page-description', 'Upload file Excel untuk mengimpor data kehadiran karyawan')

@section('content')
    <div class="space-y-6">
        <!-- Header Card -->
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        📤 Import Data <span class="text-yellow-400">Absen Bulanan</span>
                    </h2>
                    <p class="text-gray-400 text-lg">Upload file Excel untuk mengimpor data kehadiran karyawan</p>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('absen.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-700 text-white font-medium rounded-lg hover:bg-gray-600 transition-all duration-300">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
        @if (session('success'))
            <div class="glass-card rounded-2xl p-8">
                <div class="flex items-center p-4 bg-green-500/10 rounded-lg border border-green-500/20">
                    <div class="w-10 h-10 bg-green-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check text-green-400"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-green-400">Import Berhasil!</h3>
                        <p class="text-green-300">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Import Instructions -->
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-white mb-4">📋 Petunjuk Import Data</h3>
                    <div class="space-y-3 text-gray-300">
                        <div class="flex items-center p-3 bg-gray-800/30 rounded-lg border border-gray-700/50">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                            <span>File harus dalam format Excel (.xlsx atau .xls)</span>
                        </div>
                        <div class="flex items-center p-3 bg-gray-800/30 rounded-lg border border-gray-700/50">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                            <span>Pastikan format data sesuai dengan template yang disediakan</span>
                        </div>
                        <div class="flex items-center p-3 bg-gray-800/30 rounded-lg border border-gray-700/50">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                            <span>Status kehadiran: H (Hadir), S (Sakit), I (Izin), A (Alpha), T (Terlambat), L
                                (Libur)</span>
                        </div>
                        <div class="flex items-center p-3 bg-gray-800/30 rounded-lg border border-gray-700/50">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full mr-3"></div>
                            <span>Maksimal ukuran file 10MB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Import Form -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">📁 Form Import Data</h3>

            <form method="POST" action="{{ route('absen.import.proses') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <!-- Month Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Pilih Bulan
                    </label>
                    <input type="month" name="bulan" required
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    @error('bulan')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- File Upload -->
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">
                        <i class="fas fa-file-excel mr-2"></i>
                        File Excel
                    </label>
                    <div class="relative">
                        <input type="file" name="file" required accept=".xlsx,.xls"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-yellow-400 file:text-black hover:file:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    </div>
                    @error('file')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-400">Format yang didukung: .xlsx, .xls (Maksimal 10MB)</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col md:flex-row gap-4 pt-6">
                    <button type="submit"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-lg hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-upload mr-2"></i>
                        Import Data Absen
                    </button>

                    <a href="{{ route('absen.index') }}"
                        class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-700 text-white font-medium rounded-lg hover:bg-gray-600 transition-all duration-300">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Download Template -->
        {{-- <div class="glass-card rounded-2xl p-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-download text-green-400"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-white">📥 Template Excel</h3>
                    <p class="text-gray-400">Download template untuk format yang benar</p>
                </div>
            </div>
            <button class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-400 to-green-500 text-white font-medium rounded-lg hover:from-green-500 hover:to-green-600 transition-all duration-300 shadow-lg hover:shadow-green-500/25">
                <i class="fas fa-download mr-2"></i>
                Download Template
            </button>
        </div>
    </div> --}}

        <!-- Recent Imports -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">📊 Import Terbaru</h3>
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-alt text-blue-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Desember 2024</p>
                        <p class="text-gray-400 text-sm">Import terakhir: 2 hari yang lalu</p>
                    </div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                        Berhasil
                    </span>
                </div>

                <div class="flex items-center p-4 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-calendar-alt text-blue-400"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">November 2024</p>
                        <p class="text-gray-400 text-sm">Import terakhir: 1 minggu yang lalu</p>
                    </div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                        Berhasil
                    </span>
                </div>
            </div>
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        input[type="month"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
    </style>
@endsection
