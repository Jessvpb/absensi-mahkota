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
                    <p class="text-gray-400 font-medium">Pantau riwayat penggajian karyawan per
                        {{ now()->translatedFormat('F Y') }}</p>
                </div>
                <div>
                    <a href="{{ route('slip.riwayat.pdf') }}"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg shadow-green-500/20">
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
                    <label class="block text-sm font-bold text-gray-300 mb-2">Bulan</label>
                    <select name="month"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all text-base font-medium">
                        <option value="">-- Semua Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Tahun</label>
                    <select name="year"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all text-base font-medium">
                        <option value="">-- Semua Tahun --</option>
                        @for ($i = 2020; $i <= now()->year; $i++)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 text-base">
                        <i class="fas fa-search mr-2"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="glass-card rounded-2xl overflow-hidden border border-gray-700/50">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-800/80 border-b-2 border-gray-700">
                        <tr>
                            <th class="px-6 py-5 text-left text-sm font-bold text-gray-200 uppercase tracking-wider">Periode
                            </th>
                            <th class="px-6 py-5 text-left text-sm font-bold text-gray-200 uppercase tracking-wider">
                                Karyawan (Klik Detail)</th>
                            <th class="px-6 py-5 text-left text-sm font-bold text-gray-200 uppercase tracking-wider">Cabang
                            </th>
                            <th class="px-6 py-5 text-right text-sm font-bold text-gray-200 uppercase tracking-wider">Gaji
                                Pokok</th>
                            <th class="px-6 py-5 text-right text-sm font-bold text-gray-200 uppercase tracking-wider">
                                Tunjangan</th>
                            <th
                                class="px-6 py-5 text-right text-sm font-bold text-red-400 uppercase tracking-wider bg-red-500/5">
                                Total Potongan</th>
                            <th
                                class="px-6 py-5 text-right text-sm font-bold text-yellow-400 uppercase tracking-wider bg-yellow-400/5">
                                Gaji Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 bg-gray-900/20">
                        @forelse($payrolls as $payroll)
                            <tr class="hover:bg-gray-800/40 transition-colors duration-150 group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span
                                        class="text-gray-200 font-bold text-base">{{ \Carbon\Carbon::parse($payroll->periode)->translatedFormat('M Y') }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    <a href="{{ route('slip.karyawan.detail', $payroll->id) }}" class="block group">
                                        <div
                                            class="text-white font-bold text-base group-hover:text-yellow-400 transition-colors">
                                            {{ $payroll->staff->nama ?? 'N/A' }}
                                        </div>
                                        <div
                                            class="text-[10px] text-gray-500 font-bold uppercase group-hover:text-gray-300">
                                            Detail Slip →
                                        </div>
                                    </a>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="text-purple-400 text-sm font-bold bg-purple-500/10 px-3 py-1 rounded-lg border border-purple-500/30">
                                        {{ $payroll->cabang->nama_cabang ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right text-gray-100 font-mono text-base font-bold">
                                    {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-5 text-right text-gray-100 font-mono text-base">
                                    {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-5 text-right bg-red-500/5">
                                    @php
                                        $totalPotongan =
                                            ($payroll->potongan_kronologi ?? 0) +
                                            ($payroll->potongan_hutang ?? 0) +
                                            ($payroll->potongan_izin ?? 0) +
                                            ($payroll->potongan_alpha ?? 0) +
                                            ($payroll->potongan_terlambat ?? 0);
                                    @endphp
                                    <span class="text-red-400 font-mono font-bold text-base">
                                        -{{ number_format($totalPotongan, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right bg-yellow-400/5">
                                    <span class="text-green-400 font-mono font-black text-xl">
                                        {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center text-gray-500 text-lg font-bold">
                                    <i class="fas fa-inbox text-5xl mb-4 block"></i>
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
