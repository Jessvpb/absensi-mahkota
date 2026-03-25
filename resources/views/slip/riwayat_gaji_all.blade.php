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
        <div class="glass-card rounded-2xl p-6 shadow-xl">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Riwayat Penggajian</h2>
                    <p class="text-gray-400 font-medium">Klik nama karyawan untuk melihat rincian slip gaji lengkap.</p>
                </div>
                <div class="hidden-in-pdf">
                    <a href="{{ route('slip.riwayat.pdf') }}"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold rounded-xl hover:scale-105 transition-all shadow-lg shadow-green-500/20">
                        <i class="fas fa-file-pdf mr-2"></i> Cetak PDF
                    </a>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-6 hidden-in-pdf">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-yellow-400"></i> Filter Riwayat
            </h3>
            <form method="GET" action="{{ route('slip.riwayat') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Bulan</label>
                    <select name="month"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 transition-all font-medium">
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
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 transition-all font-medium">
                        <option value="">-- Semua Tahun --</option>
                        @for ($i = 2020; $i <= now()->year; $i++)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20">
                        <i class="fas fa-search mr-2"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="glass-card rounded-2xl overflow-hidden border border-gray-700/50 shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead class="bg-gray-800/80 border-b-2 border-gray-700">
                        <tr>
                            <th class="px-6 py-5 text-sm font-bold text-gray-200 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-5 text-sm font-bold text-gray-200 uppercase tracking-wider">Karyawan (Klik
                                Detail)</th>
                            <th class="px-6 py-5 text-sm font-bold text-gray-200 uppercase tracking-wider">Cabang</th>
                            <th class="px-6 py-5 text-right text-sm font-bold text-red-400 uppercase tracking-wider">Total
                                Potongan</th>
                            <th class="px-6 py-5 text-right text-sm font-bold text-green-400 uppercase tracking-wider">Gaji
                                Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50 bg-gray-900/20">
                        @forelse($payrolls as $payroll)
                            <tr class="hover:bg-yellow-400/5 transition-all duration-150 group">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <span
                                        class="text-gray-300 font-bold">{{ \Carbon\Carbon::parse($payroll->periode)->translatedFormat('M Y') }}</span>
                                </td>
                                <td class="px-6 py-5">
                                    {{-- Nama Karyawan sebagai Link Detail --}}
                                    <a href="{{ route('slip.karyawan.detail', $payroll->id) }}" class="group block">
                                        <div
                                            class="text-white font-black text-lg group-hover:text-yellow-400 transition-colors">
                                            {{ $payroll->staff->nama ?? 'N/A' }}
                                        </div>
                                        <div
                                            class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-0.5 group-hover:text-gray-300">
                                            Lihat Slip Gaji <i class="fas fa-arrow-right ml-1"></i>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-6 py-5">
                                    <span
                                        class="text-purple-400 text-xs font-bold bg-purple-500/10 px-3 py-1 rounded-lg border border-purple-500/30">
                                        {{ $payroll->cabang->nama_cabang ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-5 text-right">
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
                                <td class="px-6 py-5 text-right">
                                    <span class="text-green-400 font-mono font-black text-xl">
                                        {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-gray-500 text-lg font-bold">
                                    <i class="fas fa-inbox text-5xl mb-4 block text-gray-700"></i>
                                    Belum ada data riwayat penggajian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
