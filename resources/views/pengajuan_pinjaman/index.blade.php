@extends('layouts.app')

@section('title', 'Pengajuan Pinjaman')
@section('page-title', 'Pengajuan Pinjaman')
@section('page-description', 'Kelola pengajuan pinjaman karyawan')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Pengajuan Pinjaman</h2>
                <p class="text-gray-400">Kelola dan pantau pengajuan pinjaman karyawan</p>
            </div>
            @if(auth()->user()->role !== 'admin')
            <a href="{{ route('pinjaman.addView') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                <i class="fas fa-plus mr-2"></i>
                Ajukan Pinjaman
            </a>
            @endif
        </div>
    </div>

    <!-- Filter -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-filter mr-2 text-yellow-400"></i>
            Filter Status
        </h3>

        <form method="GET" action="{{ route('pinjaman.view') }}" class="flex items-end gap-4">
            <div class="flex-1 max-w-xs">
                <label class="block text-sm font-medium text-gray-300 mb-2">Status Pengajuan</label>
                <select name="filter" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    <option value="semua" {{ request('filter') == 'semua' ? 'selected' : '' }}>
                        Semua Status
                    </option>
                    <option value="menunggu" {{ request('filter') == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>
                    <option value="disetujui" {{ request('filter') == 'disetujui' ? 'selected' : '' }}>
                        Disetujui
                    </option>
                    <option value="ditolak" {{ request('filter') == 'ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>
                </select>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        @php
            $totalPengajuan = $data->count();
            $menunggu = $data->whereNull('validasi_admin')->count();
            $disetujui = $data->where('validasi_admin', 1)->count();
            $ditolak = $data->where('validasi_admin', 0)->count();
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
                    <p class="text-gray-400 text-sm font-medium">Disetujui</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $disetujui }}</p>
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
                            Karyawan
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                            Jumlah Pinjaman
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-calendar-alt mr-2 text-yellow-400"></i>
                            Periode
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
                    @forelse($data as $pinjaman)
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-white font-medium">{{ $pinjaman->staff->nama ?? 'Anda' }}</div>
                                        <div class="text-gray-400 text-sm">{{ $pinjaman->staff->jabatan[0]->nama_jabatan ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="text-white font-medium">Rp {{ number_format($pinjaman->jumlah_pinjaman, 0, ',', '.') }}</div>
                                    <div class="text-gray-400 text-sm flex items-center mt-1">
                                        <i class="fas fa-calculator mr-1"></i>
                                        Cicilan: Rp {{ number_format($pinjaman->jumlah_pinjaman / $pinjaman->periode_pelunasan, 0, ',', '.') }}/bulan
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $pinjaman->periode_pelunasan }} bulan
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if (is_null($pinjaman->validasi_admin))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu
                                    </span>
                                @elseif ($pinjaman->validasi_admin === 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('pinjaman.detail', $pinjaman->id) }}"
                                       class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200 border border-blue-500/30">
                                        <i class="fas fa-eye mr-2"></i>
                                        Detail
                                    </a>

                                    @if(auth()->user()->role === 'admin' && is_null($pinjaman->validasi_admin))
                                        <form action="{{ route('pinjaman.validasi', $pinjaman->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" name="aksi" value="terima"
                                                    class="inline-flex items-center px-3 py-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors duration-200 border border-green-500/30"
                                                    onclick="return confirm('Yakin ingin menyetujui pinjaman ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('pinjaman.validasi', $pinjaman->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" name="aksi" value="tolak"
                                                    class="inline-flex items-center px-3 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors duration-200 border border-red-500/30"
                                                    onclick="return confirm('Yakin ingin menolak pinjaman ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-money-bill-wave text-4xl text-gray-600 mb-4"></i>
                                    <p class="text-gray-400 text-lg">Tidak ada pengajuan pinjaman</p>
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
    @if(auth()->user()->role === 'admin' && $data->count() > 0)
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
                            <p class="text-green-400 font-medium">Disetujui Hari Ini</p>
                            <p class="text-2xl font-bold text-white">{{ $disetujui }}</p>
                        </div>
                        <i class="fas fa-check-circle text-2xl text-green-400"></i>
                    </div>
                </div>

                <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-400 font-medium">Total Nilai</p>
                            <p class="text-lg font-bold text-white">Rp {{ number_format($data->sum('jumlah_pinjaman'), 0, ',', '.') }}</p>
                        </div>
                        <i class="fas fa-money-bill-wave text-2xl text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@if (session('success'))
<div class="fixed bottom-4 right-4 bg-green-500/90 text-white px-6 py-3 rounded-lg shadow-lg">
    <div class="flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        {{ session('success') }}
    </div>
</div>
@endif
@endsection
