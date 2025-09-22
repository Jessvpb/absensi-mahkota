@extends('layouts.app')

@section('title', 'Edit Staff')
@section('page-title', 'Edit Staff')
@section('page-description', 'Edit data karyawan ' . $staff->nama)

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Edit Staff: {{ $staff->nama }}</h2>
                    <p class="text-gray-400">Update informasi karyawan</p>
                </div>
                <a href="{{ route('staff.view') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600/50 text-gray-300 rounded-lg hover:bg-gray-600/70 transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="glass-card rounded-2xl p-6 border border-red-500/30 bg-red-500/10">
                <div class="flex items-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-2"></i>
                    <h3 class="text-red-400 font-semibold">Terdapat kesalahan:</h3>
                </div>
                <ul class="space-y-2">
                    @foreach ($errors->all() as $err)
                        <li class="text-red-300 text-sm flex items-center">
                            <i class="fas fa-dot-circle mr-2 text-xs"></i>
                            {{ $err }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('staff.edit', $staff->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            <!-- Personal Information -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-user mr-2 text-yellow-400"></i>
                    Informasi Personal
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-id-card mr-1 text-yellow-400"></i>
                            NIP
                        </label>
                        <input type="text" name="NIP" value="{{ old('NIP', $staff->NIP) }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-user mr-1 text-yellow-400"></i>
                            Nama Lengkap
                        </label>
                        <input type="text" name="nama" value="{{ old('nama', $staff->nama) }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-venus-mars mr-1 text-yellow-400"></i>
                            Jenis Kelamin
                        </label>
                        <select name="JK"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                            <option value="L" {{ old('JK', $staff->JK) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('JK', $staff->JK) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Tanggal Lahir -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-calendar mr-1 text-yellow-400"></i>
                            Tanggal Lahir
                        </label>
                        <input type="date" name="TTL" value="{{ old('TTL', $staff->TTL) }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                    </div>

                    <!-- No Telepon -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-phone mr-1 text-yellow-400"></i>
                            No Telepon
                        </label>
                        <input type="text" name="notel" value="{{ old('notel', $staff->notel) }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                    </div>

                    <!-- Alamat -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-map-marker-alt mr-1 text-yellow-400"></i>
                            Alamat
                        </label>
                        <textarea name="alamat" rows="3"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>{{ old('alamat', $staff->alamat) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Employment Information -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-briefcase mr-2 text-yellow-400"></i>
                    Informasi Pekerjaan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal Masuk -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-calendar-plus mr-1 text-yellow-400"></i>
                            Tanggal Masuk
                        </label>
                        <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk', $staff->tgl_masuk) }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                    </div>

                    <!-- Tanggal Keluar -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-calendar-minus mr-1 text-yellow-400"></i>
                            Tanggal Keluar
                        </label>
                        <input type="date" name="tgl_keluar" value="{{ old('tgl_keluar', $staff->tgl_keluar) }}"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-toggle-on mr-1 text-yellow-400"></i>
                            Status Aktif
                        </label>
                        <select name="is_active"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                            <option value="1" {{ old('is_active', $staff->is_active) == 1 ? 'selected' : '' }}>Aktif
                            </option>
                            <option value="0" {{ old('is_active', $staff->is_active) == 0 ? 'selected' : '' }}>Tidak
                                Aktif</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Salary Information -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
                    Informasi Gaji
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gaji Pokok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-coins mr-1 text-yellow-400"></i>
                            Gaji Pokok
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                            <input type="number" step="0.01" name="gaji_pokok"
                                value="{{ old('gaji_pokok', $staff->gaji_pokok) }}"
                                class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                                required>
                        </div>
                    </div>

                    <!-- Gaji Tunjangan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-2">
                            <i class="fas fa-hand-holding-usd mr-1 text-yellow-400"></i>
                            Gaji Tunjangan
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                            <input type="number" step="0.01" name="gaji_tunjangan"
                                value="{{ old('gaji_tunjangan', $staff->gaji_tunjangan) }}"
                                class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                                required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Position Changes -->
            <div class="glass-card rounded-2xl p-6">
                <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                    <i class="fas fa-exchange-alt mr-2 text-yellow-400"></i>
                    Perubahan Posisi
                </h3>

                <div class="space-y-6">
                    <!-- Cabang Section -->
                    <div class="border border-gray-700/50 rounded-xl p-6 bg-gray-800/20">
                        <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                            <i class="fas fa-building mr-2 text-blue-400"></i>
                            Cabang
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Cabang Aktif Sekarang</label>
                                <select name="cabang_id_new" id="cabang_select"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                                    required>
                                    @foreach ($cabang as $c)
                                        <option value="{{ $c->id }}"
                                            {{ $cabangAktif?->id == $c->id ? 'selected' : '' }}>
                                            {{ $c->nama_cabang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="cabang_dates" class="mt-4 space-y-4 hidden">
                            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-4">
                                <p class="text-yellow-400 text-sm mb-4">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Anda mengubah cabang. Silakan isi tanggal perubahan.
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Selesai Cabang
                                            Lama</label>
                                        <input type="date" name="cabang_tgl_selesai"
                                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Mulai Cabang
                                            Baru</label>
                                        <input type="date" name="cabang_tgl_mulai" value="{{ date('Y-m-d') }}"
                                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Selesai
                                            (Opsional)</label>
                                        <input type="date" name="cabang_tgl_selesai_new"
                                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jabatan Section -->
                    <div class="border border-gray-700/50 rounded-xl p-6 bg-gray-800/20">
                        <h4 class="text-lg font-medium text-white mb-4 flex items-center">
                            <i class="fas fa-user-tie mr-2 text-purple-400"></i>
                            Jabatan
                        </h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Jabatan Aktif Sekarang</label>
                                <select name="jabatan_id_new" id="jabatan_select"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                                    required>
                                    @foreach ($jabatan as $j)
                                        <option value="{{ $j->id }}"
                                            {{ $jabatanAktif?->id == $j->id ? 'selected' : '' }}>
                                            {{ $j->nama_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div id="jabatan_dates" class="mt-4 space-y-4 hidden">
                            <div class="bg-purple-500/10 border border-purple-500/20 rounded-lg p-4">
                                <p class="text-purple-400 text-sm mb-4">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Anda mengubah jabatan. Silakan isi tanggal perubahan.
                                </p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Selesai Jabatan
                                            Lama</label>
                                        <input type="date" name="jabatan_tgl_selesai"
                                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Mulai Jabatan
                                            Baru</label>
                                        <input type="date" name="jabatan_tgl_mulai" value="{{ date('Y-m-d') }}"
                                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal Selesai
                                            (Opsional)</label>
                                        <input type="date" name="jabatan_tgl_selesai_new"
                                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="glass-card rounded-2xl p-6">
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('staff.view') }}"
                        class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                        <i class="fas fa-save mr-2"></i>
                        Update Staff
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cabangSelect = document.getElementById('cabang_select');
            const jabatanSelect = document.getElementById('jabatan_select');
            const cabangDates = document.getElementById('cabang_dates');
            const jabatanDates = document.getElementById('jabatan_dates');

            const originalCabang = '{{ $cabangAktif?->id }}';
            const originalJabatan = '{{ $jabatanAktif?->id }}';

            cabangSelect.addEventListener('change', function() {
                if (cabangSelect.value !== originalCabang) {
                    cabangDates.classList.remove('hidden');
                } else {
                    cabangDates.classList.add('hidden');
                }
            });

            jabatanSelect.addEventListener('change', function() {
                if (jabatanSelect.value !== originalJabatan) {
                    jabatanDates.classList.remove('hidden');
                } else {
                    jabatanDates.classList.add('hidden');
                }
            });

            // Date validation logic
            const jabatanMulai = document.querySelector('input[name="jabatan_tgl_mulai"]');
            const jabatanSelesaiLama = document.querySelector('input[name="jabatan_tgl_selesai"]');
            const jabatanSelesaiBaru = document.querySelector('input[name="jabatan_tgl_selesai_new"]');

            const cabangMulai = document.querySelector('input[name="cabang_tgl_mulai"]');
            const cabangSelesaiLama = document.querySelector('input[name="cabang_tgl_selesai"]');
            const cabangSelesaiBaru = document.querySelector('input[name="cabang_tgl_selesai_new"]');

            function updateJabatanLimits() {
                if (jabatanSelesaiLama && jabatanSelesaiLama.value)
                    jabatanMulai.min = jabatanSelesaiLama.value;

                if (jabatanSelesaiBaru && jabatanSelesaiBaru.value)
                    jabatanMulai.max = jabatanSelesaiBaru.value;

                if (jabatanMulai && jabatanMulai.value) {
                    jabatanSelesaiLama.max = jabatanMulai.value;
                    jabatanSelesaiBaru.min = jabatanMulai.value;
                }
            }

            function updateCabangLimits() {
                if (cabangSelesaiLama && cabangSelesaiLama.value)
                    cabangMulai.min = cabangSelesaiLama.value;

                if (cabangSelesaiBaru && cabangSelesaiBaru.value)
                    cabangMulai.max = cabangSelesaiBaru.value;

                if (cabangMulai && cabangMulai.value) {
                    cabangSelesaiLama.max = cabangMulai.value;
                    cabangSelesaiBaru.min = cabangMulai.value;
                }
            }

            [jabatanMulai, jabatanSelesaiLama, jabatanSelesaiBaru].forEach(input => {
                if (input) input.addEventListener('input', updateJabatanLimits);
            });

            [cabangMulai, cabangSelesaiLama, cabangSelesaiBaru].forEach(input => {
                if (input) input.addEventListener('input', updateCabangLimits);
            });

            updateJabatanLimits();
            updateCabangLimits();
        });
    </script>
    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
    </style>
@endsection
