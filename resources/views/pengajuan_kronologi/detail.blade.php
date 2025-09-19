@extends('layouts.app')

@section('title', 'Detail Pengajuan')
@section('page-title', 'Detail Pengajuan')
@section('page-description', 'Detail pengajuan Denda ' . $pengajuan->judul)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Detail Pengajuan Denda</h2>
                    <p class="text-gray-400">{{ $pengajuan->judul }}</p>
                </div>
                @if (auth()->user()->role === 'admin' || auth()->user()->role === 'kepala')
                    <a href="{{ route('kronologi.view') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                @endif
            </div>
        </div>

        <!-- Main Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Pengajuan Details -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-file-alt mr-2 text-yellow-400"></i>
                    Informasi Pengajuan
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
                            class="w-12 h-12 bg-gradient-to-br from-yellow-400/20 to-amber-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-heading text-yellow-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Judul</p>
                            <p class="text-white font-medium">{{ $pengajuan->judul }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-purple-400/20 to-purple-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-box text-purple-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Nama Barang</p>
                            <p class="text-white font-medium">{{ $pengajuan->nama_barang }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-4 bg-gray-800/30 rounded-lg">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-green-400/20 to-green-500/20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-money-bill-wave text-green-400"></i>
                        </div>
                        <div>
                            <p class="text-gray-400 text-sm">Harga Barang</p>
                            <p class="text-green-400 font-semibold text-lg">Rp
                                {{ number_format($pengajuan->harga_barang, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Approval -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-tasks mr-2 text-yellow-400"></i>
                    Status Persetujuan
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

        <!-- Penjelasan -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-align-left mr-2 text-yellow-400"></i>
                Penjelasan Detail
            </h3>
            <div class="bg-gray-800/30 rounded-lg p-6">
                <p class="text-gray-300 leading-relaxed">{!! nl2br(e($pengajuan->penjelasan)) !!}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        @if (Auth::user()->role === 'admin' || Auth::user()->role === 'kepala')
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-cogs mr-2 text-yellow-400"></i>
                    Aksi Persetujuan
                </h3>

                @if (Auth::user()->role === 'admin')
                    @if ($pengajuan->validasi_admin === null)
                        @if ($pengajuan->validasi_kepalacabang === 1)
                            <form id="adminForm" action="{{ route('kronologi.validasi', $pengajuan->id) }}"
                                method="POST" class="flex items-center space-x-4">
                                @csrf
                                <input type="hidden" name="aksi" id="adminAksi">
                                <input type="hidden" name="alasan" id="adminAlasan">
                                <button type="button" onclick="submitForm('terima', 'admin')"
                                    class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                                    <i class="fas fa-check mr-2"></i>
                                    Terima Pengajuan
                                </button>
                                <button type="button" onclick="openModal('admin')"
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

                @if (Auth::user()->role === 'kepala' && $pengajuan->validasi_kepalacabang === null)
                    <form id="kepalaForm" action="{{ route('kronologi.validasi', $pengajuan->id) }}"
                        method="POST" class="flex items-center space-x-4">
                        @csrf
                        <input type="hidden" name="aksi" id="kepalaAksi">
                        <input type="hidden" name="alasan" id="kepalaAlasan">
                        <button type="button" onclick="submitForm('terima', 'kepala')"
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-check mr-2"></i>
                            Terima Pengajuan
                        </button>
                        <button type="button" onclick="openModal('kepala')"
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
                <!-- Submitted -->
                <div class="flex items-center">
                    <div class="w-4 h-4 bg-blue-500 rounded-full mr-4"></div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Pengajuan Dibuat</p>
                        <p class="text-gray-400 text-sm">{{ $pengajuan->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <i class="fas fa-check text-blue-500"></i>
                </div>

                <!-- Kepala Cabang Review -->
                <div class="flex items-center">
                    <div
                        class="w-4 h-4 {{ $pengajuan->validasi_kepalacabang !== null ? 'bg-green-500' : 'bg-gray-500' }} rounded-full mr-4">
                    </div>
                    <div class="flex-1">
                        <p class="text-white font-medium">Review Kepala Cabang</p>
                        <p class="text-gray-400 text-sm">
                            @if ($pengajuan->validasi_kepalacabang !== null)
                                {{ $pengajuan->updated_at->format('d M Y, H:i') }}
                            @else
                                Menunggu review
                            @endif
                        </p>
                    </div>
                    @if ($pengajuan->validasi_kepalacabang !== null)
                        <i class="fas fa-check text-green-500"></i>
                    @else
                        <i class="fas fa-clock text-gray-500"></i>
                    @endif
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
                                {{ $pengajuan->updated_at->format('d M Y, H:i') }}
                            @else
                                Menunggu review
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

    <script>
        let currentRole = '';

        function openModal(role) {
            currentRole = role;
            document.getElementById('rejectionModal').classList.remove('hidden');
            document.getElementById('rejectionReason').value = '';
        }

        function closeModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
            currentRole = '';
        }

        function submitForm(aksi, role) {
            const form = document.getElementById(role + 'Form');
            document.getElementById(role + 'Aksi').value = aksi;
            form.submit();
        }

        function submitRejection() {
            const reason = document.getElementById('rejectionReason').value.trim();
            if (reason === '') {
                alert('Alasan penolakan harus diisi.');
                return;
            }
            const form = document.getElementById(currentRole + 'Form');
            document.getElementById(currentRole + 'Aksi').value = 'tolak';
            document.getElementById(currentRole + 'Alasan').value = reason;
            form.submit();
        }
    </script>
@endsection
