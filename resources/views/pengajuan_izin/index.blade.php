@extends('layouts.app')

@section('title', 'Pengajuan Izin')
@section('page-title', 'Pengajuan Izin')
@section('page-description', 'Kelola pengajuan izin karyawan')

@section('content')
<div class="space-y-6">
    <!-- Success Message -->
    @if (session('success'))
        <div class="glass-card rounded-2xl p-4 border border-green-500/30 bg-green-500/10">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                <p class="text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Header Actions -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Daftar Pengajuan Izin</h2>
                <p class="text-gray-400">Kelola dan pantau pengajuan izin karyawan</p>
            </div>
            <a href="{{ route('pengajuanizin.addView') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                <i class="fas fa-plus mr-2"></i>
                Ajukan Izin
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-filter mr-2 text-yellow-400"></i>
            Filter Status
        </h3>

        <form method="GET" action="{{ route('pengajuanizin.view') }}" class="flex items-end gap-4">
            <div class="flex-1 max-w-xs">
                <label class="block text-sm font-medium text-gray-300 mb-2">Status Pengajuan</label>
                <select name="filter" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    <option value="semua" {{ $filter == 'semua' ? 'selected' : '' }}>
                        <i class="fas fa-list"></i> Semua Status
                    </option>
                    <option value="menunggu" {{ $filter == 'menunggu' ? 'selected' : '' }}>
                        <i class="fas fa-clock"></i> Menunggu ACC
                    </option>
                    <option value="acc" {{ $filter == 'acc' ? 'selected' : '' }}>
                        <i class="fas fa-check-circle"></i> Di-ACC
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
            $totalPengajuan = $dataPengajuan->count();
            $menunggu = $dataPengajuan->filter(function($item) {
                return is_null($item->validasi_admin);
            })->count();
            $diterima = $dataPengajuan->filter(function($item) {
                return $item->validasi_admin === 1;
            })->count();
            $ditolak = $dataPengajuan->filter(function($item) {
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
                    <i class="fas fa-calendar-alt text-blue-400"></i>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Menunggu ACC</p>
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
                    <p class="text-gray-400 text-sm font-medium">Di-ACC</p>
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
                            <i class="fas fa-calendar mr-2 text-yellow-400"></i>
                            Tanggal Pengajuan
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-calendar-days mr-2 text-yellow-400"></i>
                            Jumlah Hari
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-tasks mr-2 text-yellow-400"></i>
                            Status
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-user-shield mr-2 text-yellow-400"></i>
                            Admin Validasi
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-cogs mr-2 text-yellow-400"></i>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($dataPengajuan as $izin)
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-blue-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-white font-medium">{{ $izin->staff->nama }}</div>
                                        <div class="text-gray-400 text-sm">{{ $izin->staff->jabatan->first()->nama_jabatan ?? 'Jabatan tidak tersedia' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-300">
                                    <div class="font-medium">{{ $izin->created_at->format('d M Y') }}</div>
                                    <div class="text-sm text-gray-400">{{ $izin->created_at->format('H:i') }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-days text-purple-400 mr-2"></i>
                                    <span class="text-purple-400 font-semibold">{{ $izin->detail_pengajuan_izin->count() }} Hari</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if (is_null($izin->validasi_admin))
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                        <i class="fas fa-clock mr-1"></i>
                                        Menunggu
                                    </span>
                                @elseif ($izin->validasi_admin == 1)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Di-ACC
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($izin->admin)
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-br from-green-400/20 to-green-500/20 rounded-full flex items-center justify-center mr-2">
                                            <i class="fas fa-user-shield text-green-400 text-xs"></i>
                                        </div>
                                        <span class="text-gray-300">{{ $izin->admin->nama }}</span>
                                    </div>
                                @else
                                    <span class="text-gray-500 italic">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('pengajuanizin.detail', $izin->id) }}"
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
                                    <i class="fas fa-calendar-alt text-4xl text-gray-600 mb-4"></i>
                                    <p class="text-gray-400 text-lg">Tidak ada pengajuan izin</p>
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
    @if(auth()->user()->role === 'admin')
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-bolt mr-2 text-yellow-400"></i>
                Aksi Cepat Admin
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
                            <p class="text-2xl font-bold text-white">{{ $diterima }}</p>
                        </div>
                        <i class="fas fa-check-circle text-2xl text-green-400"></i>
                    </div>
                </div>

                <div class="bg-blue-500/10 border border-blue-500/20 rounded-xl p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-400 font-medium">Total Hari Izin</p>
                            <p class="text-lg font-bold text-white">{{ $dataPengajuan->sum(function($item) { return $item->detail_pengajuan_izin->count(); }) }} Hari</p>
                        </div>
                        <i class="fas fa-calendar-days text-2xl text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Activity -->
    @if($dataPengajuan->count() > 0)
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-history mr-2 text-yellow-400"></i>
                Aktivitas Terbaru
            </h3>
            <div class="space-y-4">
                @foreach($dataPengajuan->take(5) as $recent)
                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg border border-gray-700/50">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-alt text-blue-400"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-medium">{{ $recent->staff->nama }} mengajukan izin</p>
                            <p class="text-gray-400 text-sm">{{ $recent->detail_pengajuan_izin->count() }} hari • {{ $recent->created_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            @if (is_null($recent->validasi_admin))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-500/20 text-yellow-400">
                                    Menunggu
                                </span>
                            @elseif ($recent->validasi_admin == 1)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400">
                                    Di-ACC
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-500/20 text-red-400">
                                    Ditolak
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
