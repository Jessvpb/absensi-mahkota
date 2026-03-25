@extends('layouts.app')

@section('title', 'Detail Penggajian')
@section('page-title', 'Detail Penggajian')
@section('page-description', 'Lihat rincian gaji dan potongan karyawan')

@section('content')
    @php
        // Ambil data langsung dari DB untuk memastikan angka TIDAK 0
        $month = \Carbon\Carbon::parse($payroll->periode)->month;
        $year = \Carbon\Carbon::parse($payroll->periode)->year;

        $absenData = \App\Models\Absen::where('staff_id', $payroll->staff_id)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        // Hitung real-time dari database
        $alphaCount = $absenData->where('status', 'A')->count();
        $terlambatCount = $absenData->where('status', 'T')->count();
        $sakitCount = $absenData->where('status', 'S')->count();
        $izinCount = $absenData->where('status', 'I')->count();
        $offCount = $absenData->where('status', 'O')->count();
        $totalIzin = $sakitCount + $izinCount + $offCount;
    @endphp

    <div class="space-y-6">
        <div class="glass-card rounded-2xl p-6 shadow-xl">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg shadow-yellow-500/20">
                        <i class="fas fa-user-tie text-white text-2xl"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $payroll->staff->nama ?? 'N/A' }}</h2>
                        <p class="text-gray-400 font-medium">
                            <span class="text-purple-400 font-bold">{{ $payroll->cabang->nama_cabang ?? '-' }}</span>
                            • Periode {{ \Carbon\Carbon::parse($payroll->periode)->translatedFormat('F Y') }}
                        </p>
                    </div>
                </div>
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center px-5 py-2.5 bg-gray-700/50 text-white font-bold rounded-xl hover:bg-gray-600 transition-all border border-gray-600">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <div class="glass-card rounded-2xl overflow-hidden shadow-2xl border border-gray-700/50">
            <div class="bg-gray-800/50 px-6 py-4 border-b border-gray-700">
                <h3 class="text-white font-bold flex items-center text-lg">
                    <i class="fas fa-file-invoice-dollar mr-2 text-yellow-400"></i>
                    Rincian Penghasilan & Potongan
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tbody class="divide-y divide-gray-700/50 bg-gray-900/20">
                        <tr class="hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-bold text-base">Gaji Pokok</td>
                            <td class="px-6 py-5 text-right font-mono text-xl text-white font-bold">
                                Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-bold text-base">Tunjangan</td>
                            <td class="px-6 py-5 text-right font-mono text-xl text-white font-bold">
                                Rp {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-bold text-base border-l-4 border-red-500/50">Potongan
                                Denda (Kronologi)</td>
                            <td class="px-6 py-5 text-right font-mono text-xl text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_kronologi ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-bold text-base border-l-4 border-red-500/50">Potongan
                                Peminjaman (Kasbon)</td>
                            <td class="px-6 py-5 text-right font-mono text-xl text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_hutang ?? 0, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-bold text-base border-l-4 border-red-500/50">Potongan
                                Alpha</td>
                            <td class="px-6 py-5 text-right font-mono text-xl text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_alpha ?? 0, 0, ',', '.') }}
                                <p class="text-gray-400 text-sm font-sans font-bold mt-1 italic">
                                    Total: {{ $alphaCount }} Hari
                                </p>
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-bold text-base border-l-4 border-red-500/50">Potongan
                                Izin / Melebihi Kuota</td>
                            <td class="px-6 py-5 text-right font-mono text-xl text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_izin ?? 0, 0, ',', '.') }}
                                <div class="text-gray-400 text-sm font-sans font-bold mt-2 text-right italic">
                                    <span class="block">• Sakit: {{ $sakitCount }} hari</span>
                                    <span class="block">• Izin: {{ $izinCount }} hari</span>
                                    <span class="block">• Off: {{ $offCount }} hari</span>
                                    <span class="block text-white/50">• Total Digabung: {{ $totalIzin }} hari</span>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-bold text-base border-l-4 border-red-500/50">Potongan
                                Terlambat</td>
                            <td class="px-6 py-5 text-right font-mono text-xl text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_terlambat ?? 0, 0, ',', '.') }}
                                <p class="text-gray-400 text-sm font-sans font-bold mt-1 italic">
                                    Total: {{ $terlambatCount }} Hari
                                </p>
                            </td>
                        </tr>

                        <tr class="bg-yellow-400/10 border-t-4 border-yellow-400/50">
                            <td class="px-6 py-8 text-yellow-400 font-black text-2xl uppercase tracking-widest">Gaji Bersih
                            </td>
                            <td class="px-6 py-8 text-right font-mono text-3xl text-green-400 font-black">
                                Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
