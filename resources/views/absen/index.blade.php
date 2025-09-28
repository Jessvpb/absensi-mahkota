@extends('layouts.app')

@section('title', 'Rekap Absen')
@section('page-title', 'Rekap Absen')
@section('page-description', 'Pantau kehadiran karyawan dengan mudah dan akurat')

@section('content')
    <div class="space-y-6">
        <!-- Header Card -->
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        📅 Rekap Absen Bulan <span
                            class="text-yellow-400">{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</span>
                    </h2>
                    <p class="text-gray-400 text-lg">Pantau kehadiran karyawan dengan mudah dan akurat</p>
                </div>
                <div class="hidden md:block">
                    <a href="{{ route('absen.import.form') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-upload mr-2"></i>
                        Import Excel
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-8">
                <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-400 text-sm font-medium">Total Karyawan</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ count($staffList) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-blue-400"></i>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-400 text-sm font-medium">Hari Kerja</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $jumlahHari }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-green-400"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-400 text-sm font-medium">Cabang</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ $cabangId ? 1 : count($cabangList) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-building text-purple-400"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-yellow-500/10 to-amber-500/10 border border-yellow-500/20 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-yellow-400 text-sm font-medium">Periode</p>
                            <p class="text-2xl font-bold text-white mt-1">{{ \Carbon\Carbon::parse($bulan)->format('m/Y') }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-yellow-400"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">🔍 Filter Data Absen</h3>
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Cabang</label>
                    <select name="cabang_id"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <option value="">Semua Cabang</option>
                        @foreach ($cabangList as $cabang)
                            <option value="{{ $cabang->id }}" {{ $cabangId == $cabang->id ? 'selected' : '' }}>
                                {{ $cabang->nama_cabang }}
                            </option>
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
                        <i class="fas fa-search mr-2"></i>
                        Filter Data
                    </button>
                </div>

                <div class="flex items-end">
                    <button type="button" onclick="window.print()"
                        class="w-full px-6 py-3 bg-gray-700 text-white font-medium rounded-lg hover:bg-gray-600 transition-all duration-300">
                        <i class="fas fa-print mr-2"></i>
                        Print
                    </button>
                </div>
            </form>
        </div>

        <!-- Attendance Table -->
        <div class="glass-card rounded-2xl p-8" x-data="modalHandler()">
            <h3 class="text-2xl font-bold text-white mb-6">📊 Tabel Kehadiran Karyawan</h3>

            @if (count($staffList) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-800/30 rounded-lg">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider sticky left-0 bg-gray-800 min-w-[200px] rounded-l-lg">
                                    Nama Karyawan
                                </th>
                                @for ($i = 1; $i <= $jumlahHari; $i++)
                                    <th
                                        class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider min-w-[40px]">
                                        {{ $i }}
                                    </th>
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
                                        <td class="px-3 py-4 text-center">
                                            @php
                                                $data = $absenData[$staff->id][$i][0] ?? null;
                                                $status = $data ? $data->status : '-';
                                            @endphp

                                            @if ($status !== '-')
                                                @php
                                                    $class = match ($status) {
                                                        'H'
                                                            => 'bg-green-500/20 text-green-400 border border-green-500/30',
                                                        'S'
                                                            => 'bg-yellow-500/20 text-yellow-400 border border-yellow-500/30',
                                                        'I' => 'bg-blue-500/20 text-blue-400 border border-blue-500/30',
                                                        'A' => 'bg-red-500/20 text-red-400 border border-red-500/30',
                                                        'T'
                                                            => 'bg-purple-500/20 text-purple-400 border border-purple-500/30',
                                                        'D'
                                                            => 'bg-orange-500/20 text-orange-400 border border-orange-500/30',
                                                        'E' => 'bg-pink-500/20 text-pink-400 border border-pink-500/30',
                                                        'L'
                                                            => 'bg-indigo-500/20 text-indigo-400 border border-indigo-500/30',
                                                        default
                                                            => 'bg-gray-500/20 text-gray-400 border border-gray-500/30',
                                                    };
                                                @endphp

                                                @if (in_array($status, ['I', 'S', 'D', 'C', 'O']))
                                                    <button
                                                        @click="openModal({ 
                                                    staff: '{{ $staff->nama }}',
                                                    tanggal: '{{ $data->tanggal ?? 'N/A' }}',
                                                    status: '{{ $data->status }}',
                                                    keterangan: '{{ $data->keterangan ?? '-' }}'
                                                })"
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold {{ $class }} hover:scale-110 transition-transform">
                                                        {{ $status }}
                                                    </button>
                                                @else
                                                    <span
                                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold {{ $class }}">
                                                        {{ $status }}
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-gray-500">-</span>
                                            @endif
                                        </td>
                                    @endfor
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Legend -->
                <div class="mt-8 p-6 bg-gray-800/30 rounded-lg border border-gray-700/50">
                    <h4 class="text-lg font-semibold text-white mb-4">📖 Keterangan Status</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4">
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-green-500/20 text-green-400 border border-green-500/30">H</span>
                            <span class="text-white text-sm">Hadir</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">S</span>
                            <span class="text-white text-sm">Sakit</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-blue-500/20 text-blue-400 border border-blue-500/30">I</span>
                            <span class="text-white text-sm">Izin</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-red-500/20 text-red-400 border border-red-500/30">A</span>
                            <span class="text-white text-sm">Alpha</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-purple-500/20 text-purple-400 border border-purple-500/30">T</span>
                            <span class="text-white text-sm">Terlambat</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-orange-500/20 text-orange-400 border border-orange-500/30">D</span>
                            <span class="text-white text-sm">Dispensasi</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-pink-500/20 text-pink-400 border border-pink-500/30">E</span>
                            <span class="text-white text-sm">Early Leave</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-indigo-500/20 text-indigo-400 border border-indigo-500/30">L</span>
                            <span class="text-white text-sm">Late & Early Leave</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span
                                class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold 
                        bg-gray-500/20 text-gray-400 border border-gray-500/30">-</span>
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
                    <p class="text-gray-400 mb-6">Silakan pilih cabang dan periode yang berbeda atau import data absen</p>
                    <a href="{{ route('absen.import.form') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-upload mr-2"></i>
                        Import Data Absen
                    </a>
                </div>
            @endif
        </div>

        {{-- Tabel Rekap Kehadiran Karyawan --}}
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">📊 Rekap Kehadiran Karyawan</h3>

            @if (count($staffList) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-800/30 rounded-lg">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider sticky left-0 bg-gray-800 min-w-[200px] rounded-l-lg">
                                    Karyawan
                                </th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Normal</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Off</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Terlambat</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Izin</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Sakit</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Alpha</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Dispensasi</th>
                                <th
                                    class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Cuti</th>
                            </tr>
                        </thead>
                        <tbody class="space-y-2">
                            @foreach ($staffList as $staff)
                                @php
                                    $rekap = [
                                        'H' => 0,
                                        'O' => 0,
                                        'T' => 0,
                                        'I' => 0,
                                        'S' => 0,
                                        'A' => 0,
                                        'D' => 0,
                                        'C' => 0,
                                    ];

                                    if (isset($absenData[$staff->id])) {
                                        foreach ($absenData[$staff->id] as $hari => $records) {
                                            $status = $records[0]->status ?? null;
                                            if ($status && isset($rekap[$status])) {
                                                $rekap[$status]++;
                                            }
                                        }
                                    }
                                @endphp
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
                                    <td class="px-3 py-4 text-center text-green-400 font-semibold">{{ $rekap['H'] }}
                                    </td>
                                    <td class="px-3 py-4 text-center text-gray-400">{{ $rekap['O'] }}</td>
                                    <td class="px-3 py-4 text-center text-purple-400">{{ $rekap['T'] }}</td>
                                    <td class="px-3 py-4 text-center text-blue-400">{{ $rekap['I'] }}</td>
                                    <td class="px-3 py-4 text-center text-yellow-400">{{ $rekap['S'] }}</td>
                                    <td class="px-3 py-4 text-center text-red-400">{{ $rekap['A'] }}</td>
                                    <td class="px-3 py-4 text-center text-orange-400">{{ $rekap['D'] }}</td>
                                    <td class="px-3 py-4 text-center text-pink-400">{{ $rekap['C'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-users text-2xl text-yellow-400"></i>
                    </div>
                    <h4 class="text-xl font-semibold text-white mb-2">Tidak Ada Data Karyawan</h4>
                    <p class="text-gray-400 mb-6">Silakan pilih cabang dan periode yang berbeda atau import data absen</p>
                    <a href="{{ route('absen.import.form') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 shadow-lg hover:shadow-yellow-500/25">
                        <i class="fas fa-upload mr-2"></i>
                        Import Data Absen
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail Absen -->
    <div x-data="modalHandler()" x-show="isOpen"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
        <div class="bg-white rounded-xl shadow-lg w-96 p-6 relative">
            <!-- Tombol Close -->
            <button @click="close" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700">
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4">Detail Absensi</h2>

            <div class="space-y-2">
                <p><strong>Nama:</strong> <span x-text="data.staff"></span></p>
                <p><strong>Status:</strong> <span x-text="data.status"></span></p>
                <p><strong>Tanggal:</strong> <span x-text="data.tanggal"></span></p>
                <p><strong>Keterangan:</strong> <span x-text="data.keterangan"></span></p>
            </div>

            <div class="mt-4 flex justify-end">
                <button @click="close" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs" defer></script>
    <script>
        function modalHandler() {
            return {
                isOpen: false,
                data: {},
                openModal(absen) {
                    this.data = absen;
                    this.isOpen = true;
                },
                close() {
                    this.isOpen = false;
                    this.data = {};
                }
            }
        }
    </script>


    <style>
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Override transparansi untuk kolom Nama Karyawan */
        .sticky.bg-gray-800 {
            background: rgb(31, 41, 55) !important;
            /* Warna solid dari bg-gray-800 */
            backdrop-filter: none !important;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            .glass-card,
            .glass-card * {
                visibility: visible;
            }

            .glass-card {
                position: absolute;
                left: 0;
                top: 0;
                background: white !important;
                color: black !important;
            }

            /* Pastikan kolom Nama Karyawan solid saat dicetak */
            .sticky.bg-gray-800 {
                background: #f2f2f2 !important;
                /* Warna abu-abu terang untuk cetak */
                backdrop-filter: none !important;
            }

            /* Sesuaikan warna teks dan border untuk cetak */
            .text-white {
                color: #000 !important;
            }

            .text-gray-400 {
                color: #333 !important;
            }

            .bg-blue-500\/20,
            .bg-green-500\/20,
            .bg-yellow-500\/20,
            .bg-red-500\/20,
            .bg-purple-500\/20,
            .bg-orange-500\/20,
            .bg-gray-500\/20 {
                background: #f2f2f2 !important;
                border: 1px solid #000 !important;
            }

            .text-blue-400,
            .text-green-400,
            .text-yellow-400,
            .text-red-400,
            .text-purple-400,
            .text-orange-400,
            .text-gray-400 {
                color: #000 !important;
            }
        }

        input[type="month"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
    </style>
@endsection
