@extends('layouts.app')

@section('title', 'Data Staff')
@section('page-title', 'Data Staff')
@section('page-description', 'Kelola data karyawan Mahkota Gallery')

@section('content')
<div class="space-y-6">
    <!-- Header Actions -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Daftar Staff</h2>
                <p class="text-gray-400">Kelola dan pantau data karyawan</p>
            </div>
            <a href="{{ route('staff.addView') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                <i class="fas fa-plus mr-2"></i>
                Tambah Staff
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-filter mr-2 text-yellow-400"></i>
            Filter Data
        </h3>

        <form method="GET" action="{{ route('staff.view') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                <select name="is_active" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    <option value="">-- Semua Status --</option>
                    <option value="1" {{ request('is_active')=='1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active')=='0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <!-- Cabang Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Cabang</label>
                <select name="cabang_id" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    <option value="">-- Semua Cabang --</option>
                    @foreach($cabang as $c)
                        <option value="{{ $c->id }}" {{ request('cabang_id')==$c->id ? 'selected' : '' }}>
                            {{ $c->nama_cabang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jabatan Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Jabatan</label>
                <select name="jabatan_id" class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    <option value="">-- Semua Jabatan --</option>
                    @foreach($jabatan as $j)
                        <option value="{{ $j->id }}" {{ request('jabatan_id')==$j->id ? 'selected' : '' }}>
                            {{ $j->nama_jabatan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search Bar -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Cari Staff</label>
                <input type="text" name="search" value="{{ $search ?? '' }}"
                       placeholder="Nama, NIP, No. Telp, Alamat..."
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
            </div>

            <!-- Filter Button -->
            <div class="flex items-end">
                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-search mr-2"></i>
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Staff Table -->
    <div class="glass-card rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class=System: "w-full">
                <thead class="bg-gray-800/50 border-b border-gray-700/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-user mr-2 text-yellow-400"></i>
                            Nama
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-id-card mr-2 text-yellow-400"></i>
                            NIP
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-briefcase mr-2 text-yellow-400"></i>
                            Jabatan
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-building mr-2 text-yellow-400"></i>
                            Cabang
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-toggle-on mr-2 text-yellow-400"></i>
                            Status
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-300 uppercase tracking-wider">
                            <i class="fas fa-cogs mr-2 text-yellow-400"></i>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700/50">
                    @forelse($staff as $s)
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-user text-yellow-400"></i>
                                    </div>
                                    <div>
                                        <div class="text-white font-medium">{{ $s->nama }}</div>
                                        <div class="text-gray-400 text-sm">{{ $s->JK == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-gray-300 font-mono">{{ $s->NIP }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    {{ $s->jabatan->first()->nama_jabatan ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                    {{ $s->cabang->first()->nama_cabang ?? '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($s->is_active)
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
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('staff.editView', $s->id) }}" class="inline-flex items-center px-3 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200 border border-blue-500/30">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>

                                    @auth
                                        @if (auth()->user()->role === 'admin')
                                            @if ($s->users_id)
                                                <a href="{{ route('staff.userForm', $s->id) }}" class="inline-flex items-center px-3 py-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors duration-200 border border-green-500/30">
                                                    <i class="fas fa-user-edit mr-1"></i>
                                                    Edit Akun
                                                </a>
                                            @else
                                                <a href="{{ route('staff.userForm', $s->id) }}" class="inline-flex items-center px-3 py-2 bg-yellow-500/20 text-yellow-400 rounded-lg hover:bg-yellow-500/30 transition-colors duration-200 border border-yellow-500/30">
                                                    <i class="fas fa-user-plus mr-1"></i>
                                                    Buat Akun
                                                </a>
                                            @endif
                                        @endif
                                    @endauth
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-4xl text-gray-600 mb-4"></i>
                                    <p class="text-gray-400 text-lg">Tidak ada data staff</p>
                                    <p class="text-gray-500 text-sm">Silakan tambah staff baru atau ubah filter pencarian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
