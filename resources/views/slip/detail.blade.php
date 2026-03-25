@extends('layouts.app')

@section('title', 'Detail Penggajian')
@section('page-title', 'Detail Penggajian')
@section('page-description', 'Lihat rincian gaji dan potongan karyawan')

@section('content')
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
                            <span class="text-purple-400">{{ $payroll->cabang->nama_cabang ?? '-' }}</span>
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
                <h3 class="text-white font-bold flex items-center">
                    <i class="fas fa-file-invoice-dollar mr-2 text-yellow-400"></i>
                    Rincian Penghasilan & Potongan
                </h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tbody class="divide-y divide-gray-700/50 bg-gray-900/20">
                        <tr class="hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-medium text-base">Gaji Pokok</td>
                            <td class="px-6 py-5 text-right font-mono text-lg text-white font-bold">
                                Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-medium text-base">Tunjangan</td>
                            <td class="px-6 py-5 text-right font-mono text-lg text-white font-bold">
                                Rp {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-medium text-base">Potongan Denda (Kronologi)</td>
                            <td class="px-6 py-5 text-right font-mono text-lg text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_kronologi ?? 0, 0, ',', '.') }}
                                <p class="text-gray-500 text-xs font-sans font-normal mt-1 italic">Cicilan denda
                                    pelanggaran.</p>
                            </td>
                        </tr>
                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-medium text-base">Potongan Peminjaman (Kasbon)</td>
                            <td class="px-6 py-5 text-right font-mono text-lg text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_hutang ?? 0, 0, ',', '.') }}
                                <p class="text-gray-500 text-xs font-sans font-normal mt-1 italic">Cicilan hutang/peminjaman
                                    staff.</p>
                            </td>
                        </tr>

                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-medium text-base">Potongan Alpha</td>
                            <td class="px-6 py-5 text-right font-mono text-lg text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_alpha ?? 0, 0, ',', '.') }}
                                <p class="text-gray-500 text-xs font-sans font-normal mt-1 italic">
                                    Potongan untuk {{ $payroll->absen_details['alpha_days'] ?? 0 }} hari Alpha.
                                </p>
                            </td>
                        </tr>
                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-medium text-base">Potongan Izin / Melebihi Kuota</td>
                            <td class="px-6 py-5 text-right font-mono text-lg text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_izin ?? 0, 0, ',', '.') }}
                                <div
                                    class="text-gray-500 text-xs font-sans font-normal mt-2 italic text-left md:text-right">
                                    <ul class="space-y-1">
                                        <li>• Sakit: {{ $payroll->absen_details['sakit_days'] ?? 0 }} hari</li>
                                        <li>• Izin: {{ $payroll->absen_details['izin_days'] ?? 0 }} hari</li>
                                        <li>• Off: {{ $payroll->absen_details['off_days'] ?? 0 }} hari</li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-red-500/5 transition-colors">
                            <td class="px-6 py-5 text-gray-300 font-medium text-base">Potongan Terlambat</td>
                            <td class="px-6 py-5 text-right font-mono text-lg text-red-400 font-bold">
                                - Rp {{ number_format($payroll->potongan_terlambat ?? 0, 0, ',', '.') }}
                                <p class="text-gray-500 text-xs font-sans font-normal mt-1 italic">
                                    Terdeteksi {{ $payroll->absen_details['terlambat_days'] ?? 0 }} hari terlambat.
                                </p>
                            </td>
                        </tr>

                        <tr class="bg-yellow-400/5 border-t-2 border-gray-700">
                            <td class="px-6 py-6 text-yellow-400 font-black text-xl uppercase tracking-widest">Gaji Bersih
                            </td>
                            <td class="px-6 py-6 text-right font-mono text-2xl text-green-400 font-black">
                                Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
