@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-description', 'Selamat datang di Mahkota Gallery Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Welcome Card -->
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-3xl font-bold text-white mb-2">
                        Selamat Datang, <span class="text-yellow-400">{{ Auth::user()->staff->nama ?? 'User' }}</span>!
                    </h2>
                    <p class="text-gray-400 text-lg">{{ Auth::user()->email }}</p>
                    <div class="mt-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-400/20 text-yellow-400 border border-yellow-400/30">
                            <i class="fas fa-user-tag mr-2"></i>
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div
                        class="w-24 h-24 rounded-full bg-gradient-to-br from-yellow-400/20 to-amber-500/20 flex items-center justify-center border border-yellow-400/30">
                        <i class="fas fa-crown text-4xl text-yellow-400"></i>
                    </div>
                </div>
            </div>

            <!-- Quick Stats atau Ringkasan berdasarkan role -->
            @if (auth()->user()->role === 'admin')
                <!-- Quick Stats (Admin) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-400 text-sm font-medium">Total Staff</p>
                                <p class="text-2xl font-bold text-white mt-1">{{ $totalStaff }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-blue-400"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-400 text-sm font-medium">Cabang Aktif</p>
                                <p class="text-2xl font-bold text-white mt-1">{{ $cabangAktif }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-building text-purple-400"></i>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-400 text-sm font-medium">Izin Hari Ini</p>
                                <p class="text-2xl font-bold text-white mt-1">{{ $izinHariIni }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-clock text-green-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Ringkasan Absen (Karyawan) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-400 text-sm font-medium">Hari Hadir</p>
                                <p class="text-2xl font-bold text-white mt-1">{{ $absenSummary['hadir'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check text-blue-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-red-500/10 to-red-600/10 border border-red-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-red-400 text-sm font-medium">Hari Alpha</p>
                                <p class="text-2xl font-bold text-white mt-1">{{ $absenSummary['alpha'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-red-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-times text-red-400"></i>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-yellow-500/10 to-yellow-600/10 border border-yellow-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-yellow-400 text-sm font-medium">Hari Terlambat</p>
                                <p class="text-2xl font-bold text-white mt-1">{{ $absenSummary['terlambat'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-clock text-yellow-400"></i>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-400 text-sm font-medium">Hari Izin</p>
                                <p class="text-2xl font-bold text-white mt-1">{{ $absenSummary['izin'] ?? 0 }}</p>
                            </div>
                            <div class="w-12 h-12 bg-green-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-clock text-green-400"></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-teal-500/10 to-teal-600/10 border border-teal-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-teal-400 text-sm font-medium">Jatah Izin/Alpha Bulanan</p>
                                <p
                                    class="text-2xl font-bold text-white mt-1 {{ $absenSummary['izinBulanan'] > 3 ? 'text-red-400' : 'text-green-400' }}">
                                    {{ $absenSummary['izinBulanan'] ?? 0 }}/3</p>
                            </div>
                            <div class="w-12 h-12 bg-teal-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-teal-400"></i>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-indigo-500/10 to-indigo-600/10 border border-indigo-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-400 text-sm font-medium">Jatah Cuti Tahunan</p>
                                <p
                                    class="text-2xl font-bold text-white mt-1 {{ $absenSummary['cutiTahunan'] > 10 ? 'text-red-400' : 'text-green-400' }}">
                                    {{ $absenSummary['cutiTahunan'] ?? 0 }}/10</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-check text-indigo-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Gaji (Karyawan) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                    <div
                        class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-400 text-sm font-medium">Gaji Pokok Terakhir</p>
                                <p class="text-2xl font-bold text-white mt-1">Rp
                                    {{ number_format($salarySummary['gaji_pokok'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-money-bill-wave text-purple-400"></i>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-400 text-sm font-medium">Gaji Bersih Terakhir</p>
                                <p class="text-2xl font-bold text-white mt-1">Rp
                                    {{ number_format($salarySummary['gaji_bersih'] ?? 0, 0, ',', '.') }}</p>
                            </div>
                            <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-wallet text-purple-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Sisa Jatah Ijin / Cuti --}}
            <div class="glass-card rounded-2xl p-8 mt-6">
                <h3 class="text-2xl font-bold text-white mb-6">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="bg-gradient-to-br from-teal-500/10 to-teal-600/10 border border-teal-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-teal-400 text-sm font-medium">Jatah Izin Bulanan</p>
                                <p class="text-2xl font-bold text-white mt-1 'text-green-400' }}">
                                    {{ $absenSummary['sisaIzinBulanan'] }} Hari</p>
                            </div>
                            <div class="w-12 h-12 bg-teal-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-teal-400"></i>
                            </div>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-br from-indigo-500/10 to-indigo-600/10 border border-indigo-500/20 rounded-xl p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-indigo-400 text-sm font-medium">Jatah Cuti Tahunan</p>
                                <p class="text-2xl font-bold text-white mt-1 'text-green-400' }}">
                                    {{ $absenSummary['sisaCutiTahunan'] }} Hari</p>
                            </div>
                            <div class="w-12 h-12 bg-indigo-500/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-check text-indigo-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role === 'admin')
                <!-- Quick Actions (Admin) -->
                <div class="glass-card rounded-2xl p-8 mt-6">
                    <h3 class="text-2xl font-bold text-white mb-6">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('pengajuanizin.view') }}"
                            class="group bg-gradient-to-br from-yellow-500/10 to-amber-500/10 border border-yellow-500/20 rounded-xl p-6 hover:from-yellow-500/20 hover:to-amber-500/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-yellow-500/30 transition-colors">
                                    <i class="fas fa-plus-circle text-2xl text-yellow-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Pengajuan Izin</h4>
                                <p class="text-gray-400 text-sm">Lihat pengajuan izin baru</p>
                            </div>
                        </a>

                        <a href="{{ route('kronologi.view') }}"
                            class="group bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6 hover:from-blue-500/20 hover:to-blue-600/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-500/30 transition-colors">
                                    <i class="fas fa-plus-square text-2xl text-blue-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Pengajuan Denda</h4>
                                <p class="text-gray-400 text-sm">Lihat pengajuan denda</p>
                            </div>
                        </a>

                        <a href="{{ route('pengajuanizin.riwayat') }}"
                            class="group bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6 hover:from-green-500/20 hover:to-green-600/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-green-500/30 transition-colors">
                                    <i class="fas fa-history text-2xl text-green-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Riwayat Izin</h4>
                                <p class="text-gray-400 text-sm">Lihat riwayat pengajuan</p>
                            </div>
                        </a>

                        <a href="{{ route('staff.view') }}"
                            class="group bg-gradient-to-br from-purple-500/10 to-purple-600/10 border border-purple-500/20 rounded-xl p-6 hover:from-purple-500/20 hover:to-purple-600/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-purple-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-purple-500/30 transition-colors">
                                    <i class="fas fa-users text-2xl text-purple-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Data Staff</h4>
                                <p class="text-gray-400 text-sm">Kelola data karyawan</p>
                            </div>
                        </a>

                        <a href="{{ route('reset.pw') }}"
                            class="group bg-gradient-to-br from-orange-500/10 to-orange-600/10 border border-orange-500/20 rounded-xl p-6 hover:from-orange-500/20 hover:to-orange-600/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-orange-500/30 transition-colors">
                                    <i class="fas fa-lock text-2xl text-orange-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Reset Password</h4>
                                <p class="text-gray-400 text-sm">Ubah kata sandi Anda</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            @if (auth()->user()->role === 'karyawan')
                <!-- Quick Actions (Karyawan) -->
                <div class="glass-card rounded-2xl p-8 mt-6">
                    <h3 class="text-2xl font-bold text-white mb-6">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('pengajuanizin.addView') }}"
                            class="group bg-gradient-to-br from-yellow-500/10 to-amber-500/10 border border-yellow-500/20 rounded-xl p-6 hover:from-yellow-500/20 hover:to-amber-500/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-yellow-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-yellow-500/30 transition-colors">
                                    <i class="fas fa-plus-circle text-2xl text-yellow-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Pengajuan Izin</h4>
                                <p class="text-gray-400 text-sm">Ajukan izin baru</p>
                            </div>
                        </a>

                        <a href="{{ route('kronologi.addView') }}"
                            class="group bg-gradient-to-br from-blue-500/10 to-blue-600/10 border border-blue-500/20 rounded-xl p-6 hover:from-blue-500/20 hover:to-blue-600/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-blue-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-blue-500/30 transition-colors">
                                    <i class="fas fa-plus-square text-2xl text-blue-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Pengajuan Denda</h4>
                                <p class="text-gray-400 text-sm">Ajukan Denda</p>
                            </div>
                        </a>

                        <a href="{{ route('pengajuanizin.riwayat') }}"
                            class="group bg-gradient-to-br from-green-500/10 to-green-600/10 border border-green-500/20 rounded-xl p-6 hover:from-green-500/20 hover:to-green-600/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-green-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-green-500/30 transition-colors">
                                    <i class="fas fa-history text-2xl text-green-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Riwayat Izin</h4>
                                <p class="text-gray-400 text-sm">Lihat riwayat pengajuan</p>
                            </div>
                        </a>

                        <a href="{{ route('reset.pw') }}"
                            class="group bg-gradient-to-br from-orange-500/10 to-orange-600/10 border border-orange-500/20 rounded-xl p-6 hover:from-orange-500/20 hover:to-orange-600/20 transition-all duration-300 hover:scale-105">
                            <div class="flex flex-col items-center text-center">
                                <div
                                    class="w-16 h-16 bg-orange-500/20 rounded-full flex items-center justify-center mb-4 group-hover:bg-orange-500/30 transition-colors">
                                    <i class="fas fa-lock text-2xl text-orange-400"></i>
                                </div>
                                <h4 class="text-white font-semibold mb-2">Reset Password</h4>
                                <p class="text-gray-400 text-sm">Ubah kata sandi Anda</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
