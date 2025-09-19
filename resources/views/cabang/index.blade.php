@extends('layouts.app')

@section('title', 'Data Cabang')
@section('page-title', 'Data Cabang')
@section('page-description', 'Kelola data cabang Mahkota Gallery')

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
                    <h2 class="text-2xl font-bold text-white mb-2">Data Cabang</h2>
                    <p class="text-gray-400">Kelola informasi cabang dan jam operasional</p>
                </div>
                <a href="{{ route('cabang.addView') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Cabang
                </a>
            </div>
        </div>

        <!-- Filter -->
        <!-- Filter -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-yellow-400"></i>
                Filter Data
            </h3>

            <form method="GET" action="{{ route('cabang.view') }}" class="flex items-end gap-4">
                <div class="flex-1 max-w-xs">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Status Cabang</label>
                    <select name="filter" id="filter" onchange="this.form.submit()"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                        <option value="aktif" {{ isset($filter) && $filter === 'aktif' ? 'selected' : '' }}>
                            <i class="fas fa-check-circle"></i> Aktif
                        </option>
                        <option value="nonaktif" {{ isset($filter) && $filter === 'nonaktif' ? 'selected' : '' }}>
                            <i class="fas fa-times-circle"></i> Tidak Aktif
                        </option>
                        <option value="semua" {{ isset($filter) && $filter === 'semua' ? 'selected' : '' }}>
                            <i class="fas fa-list"></i> Semua
                        </option>
                    </select>
                </div>
                <div class="flex-1 max-w-xs">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Cari Nama Cabang</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Masukkan nama cabang..."
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                </div>
                <button type="submit"
                    class="px-4 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300">
                    <i class="fas fa-search mr-2"></i> Cari
                </button>
            </form>
        </div>

        <!-- Cabang Table -->
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
                                <i class="fas fa-building mr-2 text-yellow-400"></i>
                                Nama Cabang
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-map-marker-alt mr-2 text-yellow-400"></i>
                                Alamat
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-clock mr-2 text-yellow-400"></i>
                                Jam Operasional
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
                        @forelse($dataCabang as $index => $cabang)
                            <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center">
                                        <span class="text-yellow-400 font-semibold text-sm">{{ $index + 1 }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-building text-blue-400"></i>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $cabang->nama_cabang }}</div>
                                            <div class="text-gray-400 text-sm">Cabang {{ $index + 1 }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center text-gray-300">
                                        <i class="fas fa-map-marker-alt text-red-400 mr-2"></i>
                                        <span>{{ $cabang->alamat ?? 'Alamat tidak tersedia' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center text-green-400">
                                            <i class="fas fa-sign-in-alt mr-2"></i>
                                            <span class="text-sm">Masuk:
                                                {{ \Carbon\Carbon::parse($cabang->jam_masuk)->format('H:i') }}</span>
                                        </div>
                                        <div class="flex items-center text-red-400">
                                            <i class="fas fa-sign-out-alt mr-2"></i>
                                            <span class="text-sm">Pulang:
                                                {{ \Carbon\Carbon::parse($cabang->jam_pulang)->format('H:i') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if ($cabang->is_active)
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center">
                                        <a href="{{ route('cabang.editView', $cabang->id) }}"
                                            class="inline-flex items-center px-4 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors duration-200 border border-blue-500/30">
                                            <i class="fas fa-edit mr-2"></i>
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-building text-4xl text-gray-600 mb-4"></i>
                                        <p class="text-gray-400 text-lg">Tidak ada data cabang</p>
                                        <p class="text-gray-500 text-sm">Silakan tambah cabang baru atau ubah filter
                                            pencarian</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistics Cards -->
        @if ($dataCabangSemua->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium">Total Cabang</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $dataCabangSemua->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-blue-400"></i>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium">Cabang Aktif</p>
                            <p class="text-2xl font-bold text-white mt-1">
                                {{ $dataCabangSemua->where('is_active', 1)->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm font-medium">Cabang Tidak Aktif</p>
                            <p class="text-2xl font-bold text-white mt-1">
                                {{ $dataCabangSemua->where('is_active', 0)->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- <script>
        const searchInput = document.querySelector('input[name="search"]');
        let timeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.form.submit();
            }, 500); // Submit setelah 500ms tidak ada input
        });
    </script> --}}
@endsection
