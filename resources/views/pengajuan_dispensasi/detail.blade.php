@extends('layouts.app')

@section('title', 'Detail Pengajuan Dispensasi')
@section('page-title', 'Detail Pengajuan Dispensasi')
@section('page-description', 'Detail pengajuan dispensasi karyawan')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Detail Pengajuan Dispensasi</h2>
                    <p class="text-gray-400">Informasi lengkap pengajuan dispensasi karyawan</p>
                </div>
                <a href="{{ auth()->user()->role === 'admin' ? route('pengajuandispensasi.view') : route('pengajuandispensasi.riwayat') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Main Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Staff Information -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-user mr-2 text-yellow-400"></i>
                    Informasi Staff
                </h3>

                <div class="space-y-4">
                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Nama Staff</p>
                            <p class="text-white font-medium">{{ $pengajuan->staff->nama }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-400/20 to-purple-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-briefcase text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Jabatan</p>
                            <p class="text-white font-medium">
                                {{ $pengajuan->staff->jabatan->first()->nama_jabatan ?? 'Tidak tersedia' }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400/20 to-green-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-calendar text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Tanggal Pengajuan</p>
                            <p class="text-white font-medium">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-calendar-days text-yellow-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Total Hari Dispensasi</p>
                            <p class="text-white font-medium">{{ $pengajuan->detail_pengajuan_dispensasi->count() }} Hari
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Validation -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-tasks mr-2 text-yellow-400"></i>
                    Status Validasi
                </h3>

                <div class="space-y-4">
                    <!-- Current Status -->
                    <div class="p-4 bg-gray-800/30 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <i class="fas fa-clipboard-check text-blue-400 mr-3"></i>
                                <span class="text-white font-medium">Status Pengajuan</span>
                            </div>
                            @if (is_null($pengajuan->validasi_admin))
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu
                                </span>
                            @elseif($pengajuan->validasi_admin == 1)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Diterima
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                    <i class="fas fa-times-circle mr-1"></i>
                                    Ditolak
                                </span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-700/50 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-500"
                                style="width: {{ is_null($pengajuan->validasi_admin) ? '50%' : '100%' }}"></div>
                        </div>
                    </div>

                    <!-- Admin Validator -->
                    <div class="p-4 bg-gray-800/30 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-user-shield text-purple-400 mr-3"></i>
                                <div>
                                    <span class="text-white font-medium block">Admin Validator</span>
                                    <span class="text-gray-400 text-sm">
                                        {{ $pengajuan->admin->nama ?? 'Belum divalidasi' }}
                                    </span>
                                </div>
                            </div>
                            @if ($pengajuan->admin)
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-green-400/20 to-green-500/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-green-400 text-xs"></i>
                                </div>
                            @else
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-gray-400/20 to-gray-500/20 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-gray-400 text-xs"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Validation Date -->
                    @if ($pengajuan->admin)
                        <div class="p-4 bg-gray-800/30 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-check text-green-400 mr-3"></i>
                                <div>
                                    <span class="text-white font-medium block">Tanggal Validasi</span>
                                    <span
                                        class="text-gray-400 text-sm">{{ $pengajuan->updated_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Hari Dispensasi -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-calendar-days mr-2 text-yellow-400"></i>
                Detail Hari Dispensasi
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-800/50 border-b border-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2 text-yellow-400"></i>
                                Tanggal
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-tag mr-2 text-yellow-400"></i>
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-comment mr-2 text-yellow-400"></i>
                                Keterangan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach ($pengajuan->detail_pengajuan_dispensasi->sortBy('tanggal') as $detail)
                            <tr class="hover:bg-gray-800/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-400/20 to-blue-500/20 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-calendar text-blue-400"></i>
                                        </div>
                                        <div>
                                            <div class="text-white font-medium">
                                                {{ \Carbon\Carbon::parse($detail->tanggal)->format('d M Y') }}</div>
                                            <div class="text-gray-400 text-sm">
                                                {{ \Carbon\Carbon::parse($detail->tanggal)->format('l') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @php
                                        $statusConfig = [
                                            'D' => [
                                                'label' => 'Dispensasi',
                                                'icon' => 'fas fa-clock',
                                                'color' => 'orange',
                                            ],
                                        ];
                                        $config = $statusConfig[$detail->status] ?? [
                                            'label' => ucfirst($detail->status),
                                            'icon' => 'fas fa-question',
                                            'color' => 'gray',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $config['color'] }}-500/20 text-{{ $config['color'] }}-400 border border-{{ $config['color'] }}-500/30">
                                        <i class="{{ $config['icon'] }} mr-1"></i>
                                        {{ $config['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-gray-300">{{ $detail->keterangan ?? '-' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        @if (auth()->user()->role === 'admin' && is_null($pengajuan->validasi_admin))
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-cogs mr-2 text-yellow-400"></i>
                    Aksi Validasi
                </h3>

                <div class="flex items-center space-x-4">
                    <form action="{{ route('pengajuandispensasi.validasi', $pengajuan->id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        <input type="hidden" name="aksi" value="terima">
                        <button type="submit" onclick="return confirm('Yakin ingin menerima pengajuan ini?')"
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-check mr-2"></i>
                            Terima Pengajuan
                        </button>
                    </form>

                    <form action="{{ route('pengajuandispensasi.validasi', $pengajuan->id) }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        <input type="hidden" name="aksi" value="tolak">
                        <button type="submit" onclick="return confirm('Yakin ingin menolak pengajuan ini?')"
                            class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-times mr-2"></i>
                            Tolak Pengajuan
                        </button>
                    </form>
                </div>
            </div>
        @endif

        <!-- Timeline -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-history mr-2 text-yellow-400"></i>
                Timeline Pengajuan
            </h3>
            <div class="space-y-4">
                <!-- Submitted -->
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-500 rounded-full mr-4"></div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Pengajuan Dibuat</p>
                        <p class="text-gray-400 text-sm">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <i class="fas fa-check text-blue-500"></i>
                </div>

                <!-- Admin Review -->
                <div class="flex items-center">
                    <div
                        class="w-4 h-4 {{ $pengajuan->validasi_admin !== null ? 'bg-green-500' : 'bg-gray-500' }} rounded-full mr-4">
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Review Admin</p>
                        <p class="text-gray-400 text-sm">
                            @if ($pengajuan->validasi_admin !== null)
                                {{ $pengajuan->updated_at->format('d M Y, H:i') }} - {{ $pengajuan->admin->nama }}
                            @else
                                Menunggu review admin
                            @endif
                        </p>
                    </div>
                    @if ($pengajuan->validasi_admin !== null)
                        <i class="fas fa-check text-green-500"></i>
                    @else
                        <i class="fas fa-clock text-gray-500"></i>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
