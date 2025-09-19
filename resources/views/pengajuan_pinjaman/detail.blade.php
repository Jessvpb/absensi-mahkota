@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan')
@section('page-description', 'Detail pengajuan pinjaman #' . $pinjaman->id)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Detail Pengajuan Pinjaman</h2>
                    <p class="text-gray-400">Pengajuan #{{ $pinjaman->id }}</p>
                </div>
                <a href="{{ auth()->user()->role === 'admin' ? route('pinjaman.view') : route('pinjaman.riwayat') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Main Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pengajuan Details -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                    Informasi Pinjaman
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Nama Staff</p>
                            <p class="text-white font-medium">{{ $pinjaman->staff->nama ?? 'Anda' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400/20 to-green-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-money-bill-wave text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Jumlah Pinjaman</p>
                            <p class="text-green-400 font-semibold text-lg">Rp
                                {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-400/20 to-purple-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-calendar text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Periode Pelunasan</p>
                            <p class="text-white font-medium">{{ $pinjaman->periode_pelunasan }} bulan</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-play-circle text-yellow-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Mulai Pelunasan</p>
                            <p class="text-white font-medium">
                                {{ \Carbon\Carbon::parse($pinjaman->start_pelunasan)->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Approval -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-tasks mr-2 text-yellow-400"></i>
                    Status Persetujuan
                </h3>

                <div class="space-y-4">
                    <!-- Admin Status -->
                    <div class="p-4 bg-gray-800/30 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <i class="fas fa-user-shield text-purple-400 mr-3"></i>
                                <span class="text-white font-medium">Admin</span>
                            </div>
                            @if ($pinjaman->validasi_admin === null)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu
                                </span>
                            @elseif($pinjaman->validasi_admin === 1)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Disetujui
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Ditolak
                                </span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-700/50 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $pinjaman->validasi_admin === null ? '0%' : '100%' }}"></div>
                        </div>
                    </div>

                    <!-- Overall Status -->
                    <div class="p-4 bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-600/50">
                        <div class="text-center">
                            <p class="text-gray-400 text-sm mb-2">Status Keseluruhan</p>
                            @if ($pinjaman->validasi_admin === 0)
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Pengajuan Ditolak
                                </span>
                            @elseif (is_null($pinjaman->validasi_admin))
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <i class="fas fa-clock mr-2"></i>
                                    Menunggu Persetujuan Admin
                                </span>
                            @elseif ($pinjaman->validasi_admin === 1)
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Pengajuan Diterima
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alasan -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-align-left mr-2 text-yellow-400"></i>
                Alasan Pengajuan
            </h3>
            <div class="bg-gray-800/30 rounded-lg p-6">
                <p class="text-gray-300 leading-relaxed">{{ $pinjaman->alasan }}</p>
            </div>
        </div>

        <!-- Rincian Pembayaran -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-calculator mr-2 text-yellow-400"></i>
                Rincian Pembayaran
            </h3>

            @php
                $jumlah = $pinjaman->jumlah_pinjaman;
                $periode = $pinjaman->periode_pelunasan;
                $cicilanPerBulan = $jumlah / $periode;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4 text-center">
                    <p class="text-blue-400 text-sm font-medium">Pokok Pinjaman</p>
                    <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($jumlah, 0, ',', '.') }}</p>
                </div>

                <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4 text-center">
                    <p class="text-green-400 text-sm font-medium">Cicilan/Bulan</p>
                    <p class="text-xl font-bold text-white mt-1">Rp {{ number_format($cicilanPerBulan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if (Auth::user()->role === 'admin' && $pinjaman->validasi_admin === null)
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-cogs mr-2 text-yellow-400"></i>
                    Aksi Persetujuan
                </h3>

                <form action="{{ route('pinjaman.validasi', $pinjaman->id) }}" method="POST"
                    class="flex items-center space-x-4">
                    @csrf
                    <button name="aksi" value="terima"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-check mr-2"></i>
                        Terima Pengajuan
                    </button>
                    <button name="aksi" value="tolak"
                        class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-times mr-2"></i>
                        Tolak Pengajuan
                    </button>
                </form>
            </div>
        @endif

        <!-- Timeline -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-history mr-2 text-yellow-400"></i>
                Timeline Pengajuan
            </h3>
            <div class="space-y-4">
                <!-- Submitted -->
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-500 rounded-full mr-4"></div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Pengajuan Dibuat</p>
                        <p class="text-gray-400 text-sm">{{ $pinjaman->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <i class="fas fa-check text-blue-500"></i>
                </div>

                <!-- Admin Review -->
                <div class="flex items-center">
                    <div
                        class="w-4 h-4 {{ $pinjaman->validasi_admin !== null ? 'bg-green-500' : 'bg-gray-500' }} rounded-full mr-4">
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Review Admin</p>
                        <p class="text-gray-400 text-sm">
                            @if ($pinjaman->validasi_admin !== null)
                                {{ $pinjaman->updated_at->format('d M Y, H:i') }}
                            @else
                                Menunggu review
                            @endif
                        </p>
                    </div>
                    @if ($pinjaman->validasi_admin !== null)
                        <i class="fas fa-check text-green-500"></i>
                    @else
                        <i class="fas fa-clock text-gray-500"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
