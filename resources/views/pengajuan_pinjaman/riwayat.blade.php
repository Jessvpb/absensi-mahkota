@extends('layouts.app')

@section('title', 'Riwayat Pinjaman')
@section('page-title', 'Riwayat Pinjaman')
@section('page-description', 'Riwayat pengajuan pinjaman Anda')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Riwayat Pengajuan Pinjaman</h2>
                <p class="text-gray-400">Pantau semua pengajuan pinjaman yang pernah Anda buat</p>
            </div>
            <a href="{{ route('pinjaman.addView') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                <i class="fas fa-plus mr-2"></i>
                Ajukan Baru
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="glass-card rounded-2xl p-4 border border-green-500/30 bg-green-500/10">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                <p class="text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $totalPengajuan = $pengajuan->count();
            $menunggu = $pengajuan->filter(function($item) {
                return is_null($item->validasi_admin);
            })->count();
            $diterima = $pengajuan->filter(function($item) {
                return $item->validasi_admin === 1;
            })->count();
            $ditolak = $pengajuan->filter(function($item) {
                return $item->validasi_admin === 0;
            })->count();
        @endphp

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Pengajuan</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $totalPengajuan }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Menunggu</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $menunggu }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-400"></i>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Diterima</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $diterima }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Ditolak</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $ditolak }}</p>
                </div>
                <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengajuan Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-800/50 border-b border-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-hashtag mr-2 text-yellow-400"></i>
                            No
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                            Jumlah Pinjaman
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2 text-yellow-400"></i>
                            Periode
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-calendar mr-2 text-yellow-400"></i>
                            Tanggal
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-tasks mr-2 text-yellow-400"></i>
                            Status
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-cogs mr-2 text-yellow-400"></i>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($pengajuan as $index => $item)
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center">
                                    <span class="text-yellow-400 font-semibold text-sm">{{ $index + 1 }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-white font-medium">Rp {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</div>
                                    <div class="text-gray-400 text-sm flex items-center mt-1">
                                        <i class="fas fa-calculator mr-1"></i>
                                        Cicilan: Rp {{ number_format($item->jumlah_pinjaman / $item->periode_pelunasan, 0, ',', '.') }}/bulan
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    <i class="fas fa-calendar mr-1"></i>
                                    {{ $item->periode_pelunasan }} bulan
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-300">
                                    <div class="font-medium">{{ $item->created_at->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-400">{{ $item->created_at->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if (is_null($item->validasi_admin))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu
                                    </span>
                                @elseif ($item->validasi_admin === 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Diterima
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('pinjaman.detail', $item->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200 border border-blue-500/30">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-money-bill-wave text-4xl text-gray-600 mb-4"></i>
                                    <p class="text-gray-400 text-lg">Belum ada pengajuan pinjaman</p>
                                    <p class="text-gray-500 text-sm mb-4">Mulai buat pengajuan pinjaman pertama Anda</p>
                                    <a href="{{ route('pinjaman.addView') }}" class="inline-flex items-center px-4 py-2 bg-yellow-400/20 text-yellow-400 rounded-lg hover:bg-yellow-400/30 transition-colors duration-200 border border-yellow-400/30">
                                        <i class="fas fa-plus mr-2"></i>
                                        Buat Pengajuan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Activity -->
    @if($pengajuan->count() > 0)
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-chart-line mr-2 text-yellow-400"></i>
                Ringkasan Aktivitas
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Total Value -->
                <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-400 text-sm font-medium">Total Nilai Pengajuan</p>
                            <p class="text-2xl font-bold text-white mt-1">Rp {{ number_format($pengajuan->sum('jumlah_pinjaman'), 0, ',', '.') }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-money-bill-wave text-green-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Success Rate -->
                <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-400 text-sm font-medium">Tingkat Persetujuan</p>
                            <p class="text-2xl font-bold text-white mt-1">
                                {{ $totalPengajuan > 0 ? round(($diterima / $totalPengajuan) * 100) : 0 }}%
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-pie text-blue-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
