@extends('layouts.app')

@section('title', 'Riwayat Penggajian')
@section('page-title', 'Riwayat Penggajian')
@section('page-description', 'Lihat riwayat penggajian karyawan Mahkota Gallery per bulan')

@section('content')
    <style>
        @media print {
            .glass-card {
                background: none;
                border: 1px solid #ddd;
                box-shadow: none;
            }

            .bg-gradient-to-r {
                background: none !important;
                color: #000 !important;
                border: 1px solid #000;
            }

            .text-white {
                color: #000 !important;
            }

            .text-gray-300,
            .text-gray-400,
            .text-gray-500 {
                color: #333 !important;
            }

            .hidden-in-pdf {
                display: none !important;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                font-size: 10pt;
            }
        }
    </style>

    <div class="space-y-6">
        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Riwayat Penggajian</h2>
                    <p class="text-gray-400">Pantau riwayat penggajian karyawan per {{ now()->translatedFormat('F Y') }}</p>
                </div>
                <div>
                    <a href="{{ route('slip.riwayat.pdf') }}"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-green-500/20">
                        <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-yellow-400"></i> Filter Riwayat
            </h3>
            <form method="GET" action="{{ route('slip.riwayat') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Bulan</label>
                    <select name="month"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                        <option value="">-- Semua Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tahun</label>
                    <select name="year"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                        <option value="">-- Semua Tahun --</option>
                        @for ($i = 2020; $i <= now()->year; $i++)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20">
                        <i class="fas fa-search mr-2"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="glass-card rounded-2xl overflow-hidden border border-gray-700/50">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-800/80 border-b border-gray-700">
                        <tr>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-32">
                                Periode</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Karyawan</th>
                            <th class="px-4 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Cabang
                            </th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Gaji
                                Pokok</th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Tunjangan</th>
                            <th
                                class="px-4 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider text-red-400">
                                Total Potongan</th>
                            <th class="px-4 py-4 text-right text-xs font-bold text-yellow-400 uppercase tracking-wider">Gaji
                                Bersih</th>
                            <th
                                class="px-4 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider hidden-in-pdf w-28">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 bg-gray-900/20">
                        @forelse($payrolls as $payroll)
                            <tr class="hover:bg-gray-800/40 transition-colors duration-150">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span
                                        class="text-gray-300 font-medium">{{ \Carbon\Carbon::parse($payroll->periode)->translatedFormat('M Y') }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center">
                                        <div class="text-white font-semibold">{{ $payroll->staff->nama ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td class="px-4 py-4">
                                    <span
                                        class="text-purple-400 text-sm bg-purple-500/10 px-2 py-1 rounded border border-purple-500/20">
                                        {{ $payroll->cabang->nama_cabang ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right text-gray-300 font-mono">
                                    {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right text-gray-300 font-mono">
                                    {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-4 text-right">
                                    @php
                                        $totalPotongan =
                                            ($payroll->potongan_kronologi ?? 0) +
                                            ($payroll->potongan_hutang ?? 0) +
                                            ($payroll->potongan_izin ?? 0) +
                                            ($payroll->potongan_alpha ?? 0) +
                                            ($payroll->potongan_terlambat ?? 0);
                                    @endphp
                                    <span class="text-red-400 font-mono font-medium">
                                        ({{ number_format($totalPotongan, 0, ',', '.') }})
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="text-green-400 font-mono font-bold text-base">
                                        {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-center hidden-in-pdf">
                                    <a href="{{ route('slip.karyawan.detail', $payroll->id) }}"
                                        class="p-2 bg-blue-500/10 text-blue-400 rounded-lg hover:bg-blue-500 hover:text-white transition-all border border-blue-500/20"
                                        title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-3 block"></i>
                                    Belum ada data penggajian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
