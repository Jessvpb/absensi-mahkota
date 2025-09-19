@extends('layouts.app')

@section('title', 'Riwayat Absen')
@section('page-title', 'Riwayat Absen')
@section('page-description', 'Lihat riwayat kehadiran Anda dalam tampilan kalender')

@section('content')
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="glass-card rounded-2xl p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        📅 Riwayat Absen <span
                            class="text-yellow-400">{{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</span>
                    </h2>
                    <p class="text-gray-400 text-lg">Pantau kehadiran Anda dengan tampilan kalender yang interaktif</p>
                </div>
                <div class="hidden md:block">
                    <div
                        class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-400/20 to-amber-500/20 flex items-center justify-center border border-yellow-400/30">
                        <i class="fas fa-calendar-check text-4xl text-yellow-400"></i>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="mt-8 p-6 bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl">
                <form method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-blue-400 text-sm font-medium mb-2">
                            <i class="fas fa-calendar-alt mr-2"></i>Pilih Bulan
                        </label>
                        <input type="month" name="bulan" id="bulan" value="{{ $bulan }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-blue-400 to-cyan-500 text-white font-semibold rounded-lg hover:from-blue-500 hover:to-cyan-600 transition-all duration-300 shadow-lg hover:shadow-blue-500/25">
                        <i class="fas fa-search mr-2"></i>Tampilkan
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @php
                $statusCounts = [
                    'H' => $absen->where('status', 'H')->count(),
                    'T' => $absen->where('status', 'T')->count(),
                    'A' => $absen->where('status', 'A')->count(),
                    'I' => $absen->where('status', 'I')->count() + $absen->where('status', 'S')->count(),
                ];
                $totalDays = \Carbon\Carbon::parse($bulan)->daysInMonth;
            @endphp

            <div class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-400 text-sm font-medium">Hadir</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ $statusCounts['H'] }}</p>
                        <p class="text-green-300 text-xs">{{ number_format(($statusCounts['H'] / $totalDays) * 100, 1) }}%
                            dari bulan ini</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check text-green-400"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-500/10 to-amber-500/10 border border-yellow-500/20 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-400 text-sm font-medium">Terlambat</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ $statusCounts['T'] }}</p>
                        <p class="text-yellow-300 text-xs">{{ number_format(($statusCounts['T'] / $totalDays) * 100, 1) }}%
                            dari bulan ini</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-yellow-400"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-400 text-sm font-medium">Alpha</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ $statusCounts['A'] }}</p>
                        <p class="text-red-300 text-xs">{{ number_format(($statusCounts['A'] / $totalDays) * 100, 1) }}%
                            dari bulan ini</p>
                    </div>
                    <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-times text-red-400"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-400 text-sm font-medium">Izin/Sakit</p>
                        <p class="text-2xl font-bold text-white mt-1">{{ $statusCounts['I'] }}</p>
                        <p class="text-blue-300 text-xs">{{ number_format(($statusCounts['I'] / $totalDays) * 100, 1) }}%
                            dari bulan ini</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-clock text-blue-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendar View -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">
                <i class="fas fa-calendar-alt mr-3 text-yellow-400"></i>Kalender Kehadiran
            </h3>

            @php
                $startOfMonth = \Carbon\Carbon::parse($bulan)->startOfMonth();
                $endOfMonth = \Carbon\Carbon::parse($bulan)->endOfMonth();
                $startOfCalendar = $startOfMonth->copy()->startOfWeek();
                $endOfCalendar = $endOfMonth->copy()->endOfWeek();

                $absenData = $absen->keyBy(function ($item) {
                    return $item->tanggal->format('Y-m-d');
                });
            @endphp

            <!-- Calendar Header -->
            <div class="grid grid-cols-7 gap-2 mb-4">
                @foreach (['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                    <div class="text-center py-3 text-gray-400 font-semibold text-sm">
                        {{ $day }}
                    </div>
                @endforeach
            </div>

            <!-- Calendar Body -->
            <div class="grid grid-cols-7 gap-2">
                @php $currentDate = $startOfCalendar->copy(); @endphp
                @while ($currentDate <= $endOfCalendar)
                    @php
                        $dateKey = $currentDate->format('Y-m-d');
                        $absenItem = $absenData->get($dateKey);
                        $isCurrentMonth = $currentDate->month == $startOfMonth->month;
                        $isToday = $currentDate->isToday();
                        $isWeekend = $currentDate->isWeekend();
                    @endphp

                    <div class="relative group">
                        <div
                            class="aspect-square p-2 rounded-lg border transition-all duration-300 hover:scale-105 cursor-pointer
                        @if ($isToday) border-yellow-400 bg-yellow-400/10
                        @elseif(!$isCurrentMonth) border-gray-700 bg-gray-800/30 opacity-50
                        @elseif($isWeekend) border-gray-600 bg-gray-700/30
                        @else border-gray-600 bg-gray-800/50 @endif
                        @if ($absenItem) @if ($absenItem->status == 'H') border-green-500 bg-green-500/20
                            @elseif($absenItem->status == 'T') border-yellow-500 bg-yellow-500/20
                            @elseif($absenItem->status == 'A') border-red-500 bg-red-500/20
                            @elseif(in_array($absenItem->status, ['I', 'S'])) border-blue-500 bg-blue-500/20
                            @elseif(in_array($absenItem->status, ['O', 'C'])) border-purple-500 bg-purple-500/20 @endif
                        @endif">

                            <!-- Date Number -->
                            <div class="text-center">
                                <span
                                    class="text-sm font-semibold
                                @if ($isToday) text-yellow-400
                                @elseif(!$isCurrentMonth) text-gray-500
                                @else text-white @endif">
                                    {{ $currentDate->day }}
                                </span>
                            </div>

                            <!-- Status Icon -->
                            @if ($absenItem && $isCurrentMonth)
                                <div class="flex justify-center mt-1">
                                    @if ($absenItem->status == 'H')
                                        <div class="w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                    @elseif($absenItem->status == 'T')
                                        <div class="w-6 h-6 bg-yellow-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-clock text-white text-xs"></i>
                                        </div>
                                    @elseif($absenItem->status == 'A')
                                        <div class="w-6 h-6 bg-red-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-times text-white text-xs"></i>
                                        </div>
                                    @elseif($absenItem->status == 'I')
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user-clock text-white text-xs"></i>
                                        </div>
                                    @elseif($absenItem->status == 'S')
                                        <div class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user-injured text-white text-xs"></i>
                                        </div>
                                    @elseif($absenItem->status == 'O')
                                        <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-home text-white text-xs"></i>
                                        </div>
                                    @elseif($absenItem->status == 'C')
                                        <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-umbrella-beach text-white text-xs"></i>
                                        </div>
                                    @endif
                                </div>
                            @elseif($isCurrentMonth && !$isWeekend && $currentDate->isPast())
                                <div class="flex justify-center mt-1">
                                    <div class="w-6 h-6 bg-gray-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-question text-white text-xs"></i>
                                    </div>
                                </div>
                            @endif

                            <!-- Tooltip -->
                            @if ($absenItem && $isCurrentMonth)
                                <div
                                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-900 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none z-10 whitespace-nowrap">
                                    @php
                                        $statusLabels = [
                                            'H' => 'Hadir',
                                            'T' => 'Terlambat',
                                            'A' => 'Alpha',
                                            'I' => 'Izin',
                                            'S' => 'Sakit',
                                            'O' => 'Off',
                                            'C' => 'Cuti',
                                        ];
                                    @endphp
                                    <div class="font-semibold">{{ $currentDate->format('d F Y') }}</div>
                                    <div>Status: {{ $statusLabels[$absenItem->status] ?? $absenItem->status }}</div>
                                    @if ($absenItem->keterangan)
                                        <div>Keterangan: {{ $absenItem->keterangan }}</div>
                                    @endif
                                    <div
                                        class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    @php $currentDate->addDay(); @endphp
                @endwhile
            </div>

            <!-- Legend -->
            <div class="mt-8 p-6 bg-gray-800/30 rounded-xl">
                <h4 class="text-lg font-semibold text-white mb-4">
                    <i class="fas fa-info-circle mr-2 text-yellow-400"></i>Keterangan Status
                </h4>
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-white text-sm"></i>
                        </div>
                        <span class="text-white text-sm">Hadir</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-clock text-white text-sm"></i>
                        </div>
                        <span class="text-white text-sm">Terlambat</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-times text-white text-sm"></i>
                        </div>
                        <span class="text-white text-sm">Alpha</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-clock text-white text-sm"></i>
                        </div>
                        <span class="text-white text-sm">Izin</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-injured text-white text-sm"></i>
                        </div>
                        <span class="text-white text-sm">Sakit</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-home text-white text-sm"></i>
                        </div>
                        <span class="text-white text-sm">Off</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-umbrella-beach text-white text-sm"></i>
                        </div>
                        <span class="text-white text-sm">Cuti</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Table (Optional) -->
        <div class="glass-card rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-white mb-6">
                <i class="fas fa-list mr-3 text-yellow-400"></i>Detail Kehadiran
            </h3>

            @if ($absen->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-800/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Tanggal</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                                    Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700/50">
                            @foreach ($absen->sortBy('tanggal') as $a)
                                <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="p-2 bg-gradient-to-r from-blue-400 to-cyan-500 rounded-lg mr-3">
                                                <i class="fas fa-calendar text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-white">
                                                    {{ $a->tanggal->format('d F Y') }}</div>
                                                <div class="text-sm text-gray-400">
                                                    {{ $a->tanggal->translatedFormat('l') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusConfig = [
                                                'H' => ['color' => 'green', 'label' => 'Hadir', 'icon' => 'check'],
                                                'T' => ['color' => 'yellow', 'label' => 'Terlambat', 'icon' => 'clock'],
                                                'A' => ['color' => 'red', 'label' => 'Alpha', 'icon' => 'times'],
                                                'I' => ['color' => 'blue', 'label' => 'Izin', 'icon' => 'user-clock'],
                                                'S' => [
                                                    'color' => 'blue',
                                                    'label' => 'Sakit',
                                                    'icon' => 'user-injured',
                                                ],
                                                'O' => ['color' => 'purple', 'label' => 'Off', 'icon' => 'home'],
                                                'C' => [
                                                    'color' => 'purple',
                                                    'label' => 'Cuti',
                                                    'icon' => 'umbrella-beach',
                                                ],
                                            ];
                                            $config = $statusConfig[$a->status] ?? [
                                                'color' => 'gray',
                                                'label' => $a->status,
                                                'icon' => 'question',
                                            ];
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $config['color'] }}-500/20 text-{{ $config['color'] }}-400 border border-{{ $config['color'] }}-500/30">
                                            <i class="fas fa-{{ $config['icon'] }} mr-2"></i>
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-white">{{ $a->keterangan ?? '-' }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div
                        class="p-4 bg-gradient-to-r from-yellow-400 to-amber-500 rounded-full w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-black text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-2">Tidak Ada Data Absen</h3>
                    <p class="text-gray-400">Belum ada data kehadiran untuk bulan
                        {{ \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') }}</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        input[type="month"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
    </style>
@endsection
