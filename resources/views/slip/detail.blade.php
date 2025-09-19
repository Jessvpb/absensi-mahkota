@extends('layouts.app')

@section('title', 'Detail Penggajian')
@section('page-title', 'Detail Penggajian')
@section('page-description', 'Lihat detail potongan gaji Anda')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Detail Penggajian</h2>
                    <p class="text-gray-400">Periode: {{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</p>
                </div>
                <a href="{{ route('slip.karyawan.riwayat') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
        </div>

        <!-- Detail Table -->
        <div class="glass-card rounded-2xl p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <tbody class="divide-y divide-gray-700/50">
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white">Gaji Pokok</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-white font-medium">Rp
                                    {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white">Tunjangan</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-white font-medium">Rp
                                    {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white">Potongan Denda</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-red-400 font-medium">Rp
                                    {{ number_format($payroll->potongan_kronologi, 0, ',', '.') }}</span>
                                <p class="text-gray-500 text-sm">Cicilan hutang Denda.</p>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white">Potongan Peminjaman</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-red-400 font-medium">Rp
                                    {{ number_format($payroll->potongan_hutang, 0, ',', '.') }}</span>
                                <p class="text-gray-500 text-sm">Cicilan hutang peminjaman.</p>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white">Potongan Alpha</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-red-400 font-medium">Rp
                                    {{ number_format($payroll->absen_details['expected_alpha_cut'], 0, ',', '.') }}</span>
                                <p class="text-gray-500 text-sm">Potongan untuk {{ $payroll->absen_details['alpha_days'] }}
                                    hari Alpha ({{ number_format($dailyRate, 0, ',', '.') }} per hari).</p>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white">Potongan Izin</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-red-400 font-medium">Rp
                                    {{ number_format($payroll->absen_details['expected_izin_cut'], 0, ',', '.') }}</span>
                                <p class="text-gray-500 text-sm">
                                    Potongan untuk {{ $payroll->absen_details['total_izin'] }}
                                    hari Izin/Off/Sakit (di atas 3 hari termasuk Alpha,
                                    {{ number_format($dailyRate, 0, ',', '.') }} per hari).
                                </p>
                                <ul class="text-gray-400 text-sm mt-1">
                                    <li>- Off: {{ $payroll->absen_details['off_days'] }} hari</li>
                                    <li>- Sakit: {{ $payroll->absen_details['sakit_days'] }} hari</li>
                                    <li>- Total Izin/Off/Sakit: {{ $payroll->absen_details['total_izin'] }} hari</li>
                                    <li>- Sisa Cuti Tahunan: {{ $payroll->absen_details['sisa_cuti'] }} hari</li>
                                </ul>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white">Potongan Terlambat</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-red-400 font-medium">Rp
                                    {{ number_format($payroll->potongan_terlambat, 0, ',', '.') }}</span>
                                <p class="text-gray-500 text-sm">Potongan untuk
                                    {{ $payroll->absen_details['terlambat_days'] }} hari Terlambat (Rp10.000 per hari).</p>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                            <td class="px-6 py-4 text-white font-bold">Gaji Bersih</td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-white font-bold">Rp
                                    {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
