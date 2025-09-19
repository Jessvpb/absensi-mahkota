@extends('layouts.app')

@section('title', 'Pengajuan Denda')
@section('page-title', 'Pengajuan Denda')
@section('page-description', 'Kelola pengajuan Denda karyawan')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Pengajuan Denda</h2>
                <p class="text-gray-400">Kelola dan pantau pengajuan Denda karyawan</p>
            </div>
            <a href="{{ route('kronologi.addView') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                <i class="fas fa-plus mr-2"></i>
                Ajukan Denda
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-filter mr-2 text-yellow-400"></i>
            Filter Status
        </h3>

        <form method="GET" action="{{ route('kronologi.view') }}" class="flex items-end gap-4">
            <div class="flex-1 max-w-xs">
                <label class="block text-sm font-medium text-gray-300 mb-2">Status Pengajuan</label>
                <select name="status" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    <option value="semua" {{ $filter == 'semua' ? 'selected' : '' }}>
                        <i class="fas fa-list"></i> Semua Status
                    </option>
                    <option value="menunggu" {{ $filter == 'menunggu' ? 'selected' : '' }}>
                        <i class="fas fa-clock"></i> Menunggu
                    </option>
                    <option value="diterima" {{ $filter == 'diterima' ? 'selected' : '' }}>
                        <i class="fas fa-check-circle"></i> Diterima
                    </option>
                    <option value="ditolak" {{ $filter == 'ditolak' ? 'selected' : '' }}>
                        <i class="fas fa-times-circle"></i> Ditolak
                    </option>
                </select>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $totalPengajuan = $pengajuan->count();
            $menunggu = $pengajuan->filter(function($item) {
                return is_null($item->validasi_admin) || is_null($item->validasi_kepalacabang);
            })->count();
            $diterima = $pengajuan->filter(function($item) {
                return $item->validasi_admin === 1 && $item->validasi_kepalacabang === 1;
            })->count();
            $ditolak = $pengajuan->filter(function($item) {
                return $item->validasi_admin === 0 || $item->validasi_kepalacabang === 0;
            })->count();
        @endphp

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Pengajuan</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $totalPengajuan }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-400"></i>
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
                            <i class="fas fa-user mr-2 text-yellow-400"></i>
                            Staff
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-file-alt mr-2 text-yellow-400"></i>
                            Judul & Barang
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                            Harga
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
                    @forelse($pengajuan as $item)
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-white font-medium">{{ $item->staff->nama }}</div>
                                        <div class="text-gray-400 text-sm">{{ $item->staff->jabatan->first()->nama_jabatan ?? 'Jabatan tidak tersedia' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-white font-medium">{{ $item->judul }}</div>
                                    <div class="text-gray-400 text-sm flex items-center mt-1">
                                        <i class="fas fa-box mr-1"></i>
                                        {{ $item->nama_barang }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-rupiah-sign text-green-400 mr-2"></i>
                                    <span class="text-green-400 font-semibold">{{ number_format($item->harga_barang, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if (is_null($item->validasi_admin) || is_null($item->validasi_kepalacabang))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu
                                    </span>
                                @elseif ($item->validasi_admin === 0 || $item->validasi_kepalacabang === 0)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Diterima
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('kronologi.detail', $item->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200 border border-blue-500/30">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-file-alt text-4xl text-gray-600 mb-4"></i>
                                    <p class="text-gray-400 text-lg">Tidak ada pengajuan Denda</p>
                                    <p class="text-gray-500 text-sm">Silakan buat pengajuan baru atau ubah filter pencarian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'kepala')
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-400"></i>
                Aksi Cepat
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-400 font-medium">Menunggu Persetujuan</p>
                            <p class="text-2xl font-bold text-white">{{ $menunggu }}</p>
                        </div>
                        <i class="fas fa-clock text-2xl text-yellow-400"></i>
                    </div>
                </div>

                <div class="bg-green-500/10 border border-green-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-400 font-medium">Disetujui</p>
                            <p class="text-2xl font-bold text-white">{{ $diterima }}</p>
                        </div>
                        <i class="fas fa-check-circle text-2xl text-green-400"></i>
                    </div>
                </div>

                <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-400 font-medium">Total Nilai</p>
                            <p class="text-lg font-bold text-white">Rp {{ number_format($pengajuan->sum('harga_barang'), 0, ',', '.') }}</p>
                        </div>
                        <i class="fas fa-money-bill-wave text-2xl text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
