@extends('layouts.app')

@section('title', 'Jadwal Off')
@section('page-title', 'Jadwal Off Karyawan')
@section('page-description', 'Pantau jadwal off karyawan dengan mudah')

@section('content')
    <div class="space-y-6">

        <!-- Header Card -->
        <div class="glass-card rounded-2xl p-8">
            <h2 class="text-3xl font-bold text-white mb-2">📅 Jadwal Off Bulan <span
                    class="text-yellow-400">{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</span></h2>
            <p class="text-gray-400 text-lg">Pantau jadwal off karyawan dengan mudah</p>
        </div>

        <!-- Filter Section -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">🔍 Filter Data</h3>
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Cabang</label>
                    <select name="cabang_id"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Semua Cabang</option>
                        @foreach ($cabangList as $cabang)
                            <option value="{{ $cabang->id }}" {{ $cabangId == $cabang->id ? 'selected' : '' }}>
                                {{ $cabang->nama_cabang }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Bulan</label>
                    <input type="month" name="bulan" value="{{ $bulan }}"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-lg hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Jadwal Off Table -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">📊 Tabel Jadwal Off Karyawan</h3>

            @if (count($staffList) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-800/30 rounded-lg">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider sticky left-0 bg-gray-800 min-w-[200px] rounded-l-lg">
                                    Nama Karyawan</th>
                                @for ($i = 1; $i <= $jumlahHari; $i++)
                                    <th
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider min-w-[40px]">
                                        {{ $i }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody class="space-y-2">
                            @foreach ($staffList as $staff)
                                <tr
                                    class="bg-gray-800/30 rounded-lg border border-gray-700/50 hover:bg-gray-800/50 transition-colors duration-200">
                                    <td class="px-4 py-4 whitespace-nowrap sticky left-0 bg-gray-800 rounded-l-lg">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-blue-400"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-white">{{ $staff->nama }}</div>
                                                <div class="text-xs text-gray-400">ID: {{ $staff->absen_id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    @for ($i = 1; $i <= $jumlahHari; $i++)
                                        @php $color = $jadwalOff[$staff->id][$i] ?? null; @endphp
                                        <td class="px-3 py-4 text-center">
                                            @if ($color === 'red')
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-500/20 text-red-400 border border-red-500/40 font-bold">O</span>
                                            @elseif ($color === 'blue')
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/40 font-bold">O</span>
                                            @elseif ($color === 'green')
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-green-500/20 text-green-400 border border-green-500/40 font-bold">O</span>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30 font-bold">-</span>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Legend -->
                <div class="mt-6 p-4 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <h4 class="text-lg font-semibold text-white mb-4">📖 Keterangan Status</h4>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4 md:gap-6 lg:gap-8">
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-red-500/20 text-red-400 border border-red-500/40">O</span>
                            <span class="text-white text-sm">Off - Menunggu</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-blue-500/20 text-blue-400 border border-blue-500/40">O</span>
                            <span class="text-white text-sm">Off - Disetujui Kepala Cabang</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-green-500/20 text-green-400 border border-green-500/40">O</span>
                            <span class="text-white text-sm">Off - Disetujui Kepala & Admin</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-gray-500/20 text-gray-400 border border-gray-500/30">-</span>
                            <span class="text-white text-sm">Tidak Ada Data</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-yellow-400"></i>
                    </div>
                    <h4 class="text-xl font-semibold text-white mb-2">Tidak Ada Data Karyawan</h4>
                    <p class="text-gray-400 mb-6">Silakan pilih cabang dan periode yang berbeda</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sticky.bg-gray-800 {
            background: rgb(31, 41, 55) !important;
            backdrop-filter: none !important;
        }
    </style>
@endsection
