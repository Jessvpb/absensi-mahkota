@extends('layouts.app')

@section('title', 'Tambah Staff')
@section('page-title', 'Tambah Staff')
@section('page-description', 'Tambah karyawan baru ke sistem')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Tambah Staff Baru</h2>
                <p class="text-gray-400">Lengkapi form di bawah untuk menambah karyawan baru</p>
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
    <form action="{{ route('staff.add') }}" method="POST" class="space-y-6">
        @csrf

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
                    <input type="text" name="NIP" value="{{ old('NIP') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan NIP" required maxlength="12">
                    @error('NIP')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Absen ID -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-fingerprint mr-1 text-yellow-400"></i>
                        Absen ID
                    </label>
                    <input type="text" name="absen_id" value="{{ old('absen_id') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan Absen ID" required>
                    @error('absen_id')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user mr-1 text-yellow-400"></i>
                        Nama Lengkap
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan nama lengkap" required>
                    @error('nama')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
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
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('JK') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('JK') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('JK')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-1 text-yellow-400"></i>
                        Tanggal Lahir
                    </label>
                    <input type="date" name="TTL" value="{{ old('TTL') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           required>
                    @error('TTL')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-phone mr-1 text-yellow-400"></i>
                        No Telepon
                    </label>
                    <input type="text" name="notel" value="{{ old('notel') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan nomor telepon" required>
                    @error('notel')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-map-marker-alt mr-1 text-yellow-400"></i>
                        Alamat
                    </label>
                    <textarea name="alamat" rows="3"
                              class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                              placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
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
                    <input type="date" name="tgl_masuk" value="{{ old('tgl_masuk') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           required>
                    @error('tgl_masuk')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tanggal Keluar -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-calendar-minus mr-1 text-yellow-400"></i>
                        Tanggal Keluar (Opsional)
                    </label>
                    <input type="date" name="tgl_keluar" value="{{ old('tgl_keluar') }}"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all">
                    @error('tgl_keluar')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Cabang -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-building mr-1 text-yellow-400"></i>
                        Cabang
                    </label>
                    <select name="cabang_id"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                        <option value="">-- Pilih Cabang --</option>
                        @foreach ($cabang as $c)
                            <option value="{{ $c->id }}" {{ old('cabang_id') == $c->id ? 'selected' : '' }}>
                                {{ $c->nama_cabang }}
                            </option>
                        @endforeach
                    </select>
                    @error('cabang_id')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-user-tie mr-1 text-yellow-400"></i>
                        Jabatan
                    </label>
                    <select name="jabatan_id"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                        <option value="">-- Pilih Jabatan --</option>
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->id }}" {{ old('jabatan_id') == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-toggle-on mr-1 text-yellow-400"></i>
                        Status
                    </label>
                    <select name="is_active"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                            required>
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('is_active')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
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
                        <input type="text" id="gaji_pokok_display"
                               class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                               placeholder="0" autocomplete="off"
                               value="{{ old('gaji_pokok') ? number_format(old('gaji_pokok'), 0, ',', '.') : '' }}">
                        <input type="hidden" name="gaji_pokok" id="gaji_pokok_value" value="{{ old('gaji_pokok') }}">
                    </div>
                    @error('gaji_pokok')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Gaji Tunjangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        <i class="fas fa-hand-holding-usd mr-1 text-yellow-400"></i>
                        Gaji Tunjangan (Opsional)
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                        <input type="text" id="gaji_tunjangan_display"
                               class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                               placeholder="0" autocomplete="off"
                               value="{{ old('gaji_tunjangan') ? number_format(old('gaji_tunjangan'), 0, ',', '.') : '' }}">
                        <input type="hidden" name="gaji_tunjangan" id="gaji_tunjangan_value" value="{{ old('gaji_tunjangan') }}">
                    </div>
                    @error('gaji_tunjangan')
                        <p class="text-red-400 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-eye mr-2 text-blue-400"></i>
                Preview Gaji
            </h3>
            <div class="bg-gray-800/30 rounded-lg p-4">
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-coins text-green-400 mr-3 w-5"></i>
                        <span class="text-gray-400 mr-2">Gaji Pokok:</span>
                        <span class="text-green-400 font-semibold" id="preview-gaji-pokok">Rp 0</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-hand-holding-usd text-orange-400 mr-3 w-5"></i>
                        <span class="text-gray-400 mr-2">Gaji Tunjangan:</span>
                        <span class="text-orange-400 font-semibold" id="preview-gaji-tunjangan">Rp 0</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calculator text-purple-400 mr-3 w-5"></i>
                        <span class="text-gray-400 mr-2">Total Gaji:</span>
                        <span class="text-purple-400 font-semibold" id="preview-total-gaji">Rp 0</span>
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
                    Simpan Staff
                </button>
            </div>
        </div>
    </form>
</div>

<style>
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(100%);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Input elements
    const gajiPokokDisplay = document.getElementById('gaji_pokok_display');
    const gajiPokokValue = document.getElementById('gaji_pokok_value');
    const gajiTunjanganDisplay = document.getElementById('gaji_tunjangan_display');
    const gajiTunjanganValue = document.getElementById('gaji_tunjangan_value');

    // Preview elements
    const previewGajiPokok = document.getElementById('preview-gaji-pokok');
    const previewGajiTunjangan = document.getElementById('preview-gaji-tunjangan');
    const previewTotalGaji = document.getElementById('preview-total-gaji');

    // Format angka dengan titik sebagai pemisah ribuan
    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Hapus semua karakter selain angka
    function cleanNumber(str) {
        return str.replace(/[^\d]/g, '');
    }

    // Format mata uang Indonesia
    function formatCurrency(amount) {
        return 'Rp ' + formatNumber(amount.toString());
    }

    // Update preview gaji
    function updateGajiPreview() {
        const gajiPokok = parseInt(gajiPokokValue.value) || 0;
        const gajiTunjangan = parseInt(gajiTunjanganValue.value) || 0;
        const totalGaji = gajiPokok + gajiTunjangan;

        previewGajiPokok.textContent = formatCurrency(gajiPokok);
        previewGajiTunjangan.textContent = formatCurrency(gajiTunjangan);
        previewTotalGaji.textContent = formatCurrency(totalGaji);
    }

    // Event listener untuk input gaji pokok
    gajiPokokDisplay.addEventListener('input', function(e) {
        const cursorPosition = e.target.selectionStart;
        const oldValue = e.target.value;
        const cleanedValue = cleanNumber(e.target.value);

        gajiPokokValue.value = cleanedValue;
        e.target.value = cleanedValue ? formatNumber(cleanedValue) : '';

        // Hitung posisi cursor baru
        const dotsAdded = e.target.value.split('.').length - oldValue.split('.').length;
        const newCursorPosition = cursorPosition + dotsAdded;

        // Set posisi cursor
        setTimeout(() => {
            e.target.setSelectionRange(newCursorPosition, newCursorPosition);
        }, 0);

        // Update preview
        updateGajiPreview();
    });

    // Event listener untuk paste gaji pokok
    gajiPokokDisplay.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const cleanedValue = cleanNumber(pastedText);

        gajiPokokValue.value = cleanedValue;
        this.value = cleanedValue ? formatNumber(cleanedValue) : '';

        // Update preview
        updateGajiPreview();
    });

    // Mencegah input karakter non-digit pada gaji pokok
    gajiPokokDisplay.addEventListener('keydown', function(e) {
        if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    // Event listener untuk input gaji tunjangan
    gajiTunjanganDisplay.addEventListener('input', function(e) {
        const cursorPosition = e.target.selectionStart;
        const oldValue = e.target.value;
        const cleanedValue = cleanNumber(e.target.value);

        gajiTunjanganValue.value = cleanedValue;
        e.target.value = cleanedValue ? formatNumber(cleanedValue) : '';

        // Hitung posisi cursor baru
        const dotsAdded = e.target.value.split('.').length - oldValue.split('.').length;
        const newCursorPosition = cursorPosition + dotsAdded;

        // Set posisi cursor
        setTimeout(() => {
            e.target.setSelectionRange(newCursorPosition, newCursorPosition);
        }, 0);

        // Update preview
        updateGajiPreview();
    });

    // Event listener untuk paste gaji tunjangan
    gajiTunjanganDisplay.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const cleanedValue = cleanNumber(pastedText);

        gajiTunjanganValue.value = cleanedValue;
        this.value = cleanedValue ? formatNumber(cleanedValue) : '';

        // Update preview
        updateGajiPreview();
    });

    // Mencegah input karakter non-digit pada gaji tunjangan
    gajiTunjanganDisplay.addEventListener('keydown', function(e) {
        if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
            (e.keyCode === 65 && e.ctrlKey === true) ||
            (e.keyCode === 67 && e.ctrlKey === true) ||
            (e.keyCode === 86 && e.ctrlKey === true) ||
            (e.keyCode === 88 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            return;
        }
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    // Inisialisasi format jika ada nilai awal
    if (gajiPokokValue.value) {
        gajiPokokDisplay.value = formatNumber(gajiPokokValue.value);
    }
    if (gajiTunjanganValue.value) {
        gajiTunjanganDisplay.value = formatNumber(gajiTunjanganValue.value);
    }

    // Inisialisasi preview
    updateGajiPreview();
});
</script>
@endsection
