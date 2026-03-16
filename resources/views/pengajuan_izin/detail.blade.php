@extends('layouts.app')

@section('title', 'Detail Pengajuan Izin')
@section('page-title', 'Detail Pengajuan Izin')
@section('page-description', 'Detail pengajuan izin karyawan')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Detail Pengajuan Izin</h2>
                    <p class="text-gray-400">Informasi lengkap pengajuan izin karyawan</p>
                </div>
                <a href="{{ auth()->user()->role === 'admin' ? route('pengajuanizin.view') : route('pengajuanizin.riwayat') }}"
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
                            <p class="text-gray-400 text-sm">Total Hari Izin</p>
                            <p class="text-white font-medium">{{ $pengajuan->detail_pengajuan_izin->count() }} Hari</p>
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
                    <!-- Kepala Cabang Status -->
                    <div class="p-4 bg-gray-800/30 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <i class="fas fa-user-tie text-blue-400 mr-3"></i>
                                <span class="text-white font-medium">Kepala Cabang</span>
                            </div>
                            @if ($pengajuan->validasi_kepalacabang === null)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu
                                </span>
                            @elseif($pengajuan->validasi_kepalacabang === 1)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Disetujui
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
                                style="width: {{ $pengajuan->validasi_kepalacabang === null ? '0%' : '100%' }}"></div>
                        </div>
                    </div>

                    <!-- Admin Status -->
                    <div class="p-4 bg-gray-800/30 rounded-lg">
                        <div class="flex items-center justify-between mb-3">
                            <div class="flex items-center">
                                <i class="fas fa-user-shield text-purple-400 mr-3"></i>
                                <span class="text-white font-medium">Admin</span>
                            </div>
                            @if ($pengajuan->validasi_admin === null)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu
                                </span>
                            @elseif($pengajuan->validasi_admin === 1)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Disetujui
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
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full transition-all duration-500"
                                style="width: {{ $pengajuan->validasi_admin === null ? '0%' : '100%' }}"></div>
                        </div>
                    </div>

                    <!-- Overall Status -->
                    <div class="p-4 bg-gray-800/50 rounded-lg border-2 border-dashed border-gray-600/50">
                        <div class="text-center">
                            <p class="text-gray-400 text-sm mb-2">Status Keseluruhan</p>
                            @if (is_null($pengajuan->validasi_admin) || is_null($pengajuan->validasi_kepalacabang))
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    <i class="fas fa-clock mr-2"></i>
                                    Menunggu Persetujuan
                                </span>
                            @elseif ($pengajuan->validasi_admin === 0 || $pengajuan->validasi_kepalacabang === 0)
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    Pengajuan Ditolak
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-4 py-2 rounded-full text-lg font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Pengajuan Diterima
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Hari Izin -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-calendar-days mr-2 text-yellow-400"></i>
                Detail Hari Izin
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
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                <i class="fas fa-user mr-2 text-yellow-400"></i>
                                Pengganti
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @foreach ($pengajuan->detail_pengajuan_izin->sortBy('tanggal') as $detail)
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
                                            'I' => ['label' => 'Izin', 'icon' => 'fas fa-home', 'color' => 'blue'],
                                            'S' => [
                                                'label' => 'Sakit',
                                                'icon' => 'fas fa-thermometer-half',
                                                'color' => 'red',
                                            ],
                                            'C' => [
                                                'label' => 'Cuti',
                                                'icon' => 'fas fa-umbrella-beach',
                                                'color' => 'green',
                                            ],
                                            'O' => [
                                                'label' => 'Off',
                                                'icon' => 'fas fa-calendar-times',
                                                'color' => 'purple',
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
                                <td class="px-6 py-4">
                                    <span class="text-gray-300">{{ $detail->pengganti ?? '-' }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons -->
        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'kepala')
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-cogs mr-2 text-yellow-400"></i>
                    Aksi Persetujuan
                </h3>

                {{-- Admin --}}
                @if (Auth::user()->role === 'admin')
                    @if ($pengajuan->validasi_admin === null)
                        @if ($pengajuan->validasi_kepalacabang === 1)
                            <form id="adminForm" action="{{ route('pengajuanizin.validasi', $pengajuan->id) }}"
                                method="POST" class="flex items-center space-x-4">
                                @csrf
                                <input type="hidden" name="aksi" id="adminAksi">
                                <input type="hidden" name="alasan" id="adminAlasan">

                                <!-- Terima -->
                                <button type="button" onclick="submitForm('terima', 'admin')"
                                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-check mr-2"></i>
                                    Terima Pengajuan
                                </button>

                                <!-- Tolak -->
                                <button type="button" onclick="submitForm('tolak', 'admin')"
                                    class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-times mr-2"></i>
                                    Tolak Pengajuan
                                </button>
                            </form>
                        @else
                            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-xl p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-yellow-400 mr-3"></i>
                                    <p class="text-yellow-300">Menunggu persetujuan kepala cabang terlebih dahulu.</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-500/10 border border-gray-500/20 rounded-xl p-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-gray-400 mr-3"></i>
                                <p class="text-gray-300">Anda telah memberikan keputusan untuk pengajuan ini.</p>
                            </div>
                        </div>
                    @endif
                @endif

                {{-- Kepala Cabang --}}
                @if (Auth::user()->role === 'kepala' && $pengajuan->validasi_kepalacabang === null)
                    <form id="kepalaForm" action="{{ route('pengajuanizin.validasi', $pengajuan->id) }}" method="POST"
                        class="flex items-center space-x-4">
                        @csrf
                        <input type="hidden" name="aksi" id="kepalaAksi">
                        <input type="hidden" name="alasan" id="kepalaAlasan">

                        <!-- Terima -->
                        <button type="button" onclick="submitForm('terima', 'kepala')"
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-check mr-2"></i>
                            Terima Pengajuan
                        </button>

                        <!-- Tolak -->
                        <button type="button" onclick="submitForm('tolak', 'kepala')"
                            class="px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-times mr-2"></i>
                            Tolak Pengajuan
                        </button>
                    </form>
                @endif
            </div>
        @endif

        <!-- Rejection Reason Modal -->
        <div id="rejectionModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
            <div class="bg-gray-800 rounded-xl p-6 max-w-md w-full">
                <h3 class="text-xl font-semibold text-white mb-4">Alasan Penolakan</h3>
                <textarea id="rejectionReason" class="w-full p-3 bg-gray-700 text-white rounded-lg" rows="4"
                    placeholder="Masukkan alasan penolakan..." required></textarea>
                <div class="flex justify-end space-x-4 mt-4">
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">Batal</button>
                    <button id="submitRejection" onclick="submitRejection()"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Kirim</button>
                </div>
            </div>
        </div>

        <!-- Timeline -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-history mr-2 text-yellow-400"></i>
                Timeline Pengajuan
            </h3>
            <div class="space-y-4">
                <div class="relative pl-8 border-l-2 border-gray-700/50">
                    <div class="absolute left-[-7px] top-0 w-3 h-3 rounded-full bg-blue-500 border-2 border-gray-900">
                    </div>
                    <p class="text-white font-medium">Pengajuan Dibuat</p>
                    <p class="text-gray-400 text-sm">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                </div>
                @if ($pengajuan->validasi_kepalacabang !== null)
                    <div class="relative pl-8 border-l-2 border-gray-700/50">
                        <div
                            class="absolute left-[-7px] top-0 w-3 h-3 rounded-full bg-purple-500 border-2 border-gray-900">
                        </div>
                        <p class="text-white font-medium">Kepala Cabang
                            {{ $pengajuan->validasi_kepalacabang ? 'Menyetujui' : 'Menolak' }}</p>
                        <p class="text-gray-400 text-sm">
                            {{ $pengajuan->tgl_validasi_kepala ? $pengajuan->tgl_validasi_kepala->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>
                @endif
                @if ($pengajuan->validasi_admin !== null)
                    <div class="relative pl-8 border-l-2 border-gray-700/50">
                        <div class="absolute left-[-7px] top-0 w-3 h-3 rounded-full bg-green-500 border-2 border-gray-900">
                        </div>
                        <p class="text-white font-medium">Admin
                            {{ $pengajuan->validasi_admin ? 'Menyetujui' : 'Menolak' }}</p>
                        <p class="text-gray-400 text-sm">
                            {{ $pengajuan->tgl_validasi_admin ? $pengajuan->tgl_validasi_admin->format('d M Y, H:i') : '-' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function submitForm(aksi, role) {
            const form = document.getElementById(role + 'Form');
            document.getElementById(role + 'Aksi').value = aksi;

            if (aksi === 'tolak') {
                let alasan = prompt('Masukkan alasan penolakan:');
                if (!alasan) return;
                document.getElementById(role + 'Alasan').value = alasan;
            }

            form.submit();
        }
    </script>
@endsection
