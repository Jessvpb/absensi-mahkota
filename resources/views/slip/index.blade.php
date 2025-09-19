@extends('layouts.app')

@section('title', 'Penggajian Staff')
@section('page-title', 'Penggajian Staff')
@section('page-description', 'Kelola dan proses penggajian karyawan Mahkota Gallery')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="glass-card rounded-2xl p-4 border border-green-500/30 bg-green-500/10">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <p class="text-green-300">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="glass-card rounded-2xl p-4 border border-red-500/30 bg-red-500/10">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-red-400 mr-3"></i>
                    <p class="text-red-300">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Header Actions -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Penggajian Staff</h2>
                    <p class="text-gray-400">Proses penggajian dan pantau gaji karyawan per {{ now()->format('F Y') }}</p>
                </div>
                @if ($staff->isNotEmpty())
                    <form method="GET" action="{{ route('slip.proses') }}" id="payrollForm">
                        <div class="flex flex-col lg:flex-row gap-4">
                            <select name="month"
                                class="w-full lg:w-40 px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="year"
                                class="w-full lg:w-40 px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                @for ($i = 2025; $i <= 2030; $i++)
                                    <option value="{{ $i }}" {{ now()->year == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                            <button type="submit" id="processPayroll"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-green-400/25">
                                <i class="fas fa-money-bill-wave mr-2"></i>
                                Proses Penggajian
                            </button>
                        </div>
                    </form>
                @else
                    <span class="text-gray-500">Tidak ada staff untuk diproses.</span>
                @endif
            </div>
        </div>

        <!-- Filters -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-filter mr-2 text-yellow-400"></i>
                Filter Data
            </h3>

            <form method="GET" action="{{ route('slip.view') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Cabang Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Cabang</label>
                    <select name="cabang_id"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                        <option value="">-- Semua Cabang --</option>
                        @foreach ($cabang as $c)
                            <option value="{{ $c->id }}" {{ request('cabang_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-search mr-2"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Salary Table -->
        <div class="glass-card rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-800/50 border-b border-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-user mr-2 text-yellow-400"></i>
                                Nama
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-building mr-2 text-yellow-400"></i>
                                Cabang
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2 text-yellow-400"></i>
                                Tanggal Penggajian
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                                Gaji Pokok
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-hand-holding-usd mr-2 text-yellow-400"></i>
                                Tunjangan
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Alpha
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Izin
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Terlambat
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Denda
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-minus-circle mr-2 text-yellow-400"></i>
                                Pot. Peminjaman
                            </th>
                            <th class="px-6 py-4 text-right text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-wallet mr-2 text-yellow-400"></i>
                                Gaji Bersih
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($staff as $s)
                            <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-yellow-400"></i>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">{{ $s->nama }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
                                        {{ $s->cabang[0]->nama_cabang ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-300">{{ now()->format('Y-m-d H:i') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-medium">Rp
                                        {{ number_format($s->gaji_pokok, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-medium">Rp
                                        {{ number_format($s->gaji_tunjangan, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp
                                        {{ number_format($s->potongan_absen_alpha, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp
                                        {{ number_format($s->potongan_absen_izin, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp
                                        {{ number_format($s->potongan_terlambat, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp
                                        {{ number_format($s->potongan_kronologi, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-red-400 font-medium">Rp
                                        {{ number_format($s->potongan_peminjaman, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-white font-medium">Rp
                                        {{ number_format($s->gaji_bersih, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users text-4xl text-gray-600 mb-4"></i>
                                        <p class="text-gray-400 text-lg">Tidak ada data staff</p>
                                        <p class="text-gray-500 text-sm">Silakan tambah staff atau ubah filter</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var processPayrollButton = document.getElementById('processPayroll');
            if (processPayrollButton) {
                processPayrollButton.addEventListener('click', function(event) {
                    var month = document.querySelector('select[name="month"]').value;
                    var year = document.querySelector('select[name="year"]').value;
                    if (!month || !year) {
                        alert('Silakan pilih bulan dan tahun sebelum memproses penggajian.');
                        event.preventDefault();
                    }
                });
            } else {
                console.log('Elemen processPayroll tidak ditemukan di DOM.');
            }
        });
    </script>
@endsection
