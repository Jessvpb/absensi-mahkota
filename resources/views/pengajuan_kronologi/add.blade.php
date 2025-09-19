@extends('layouts.app')

@section('title', 'Ajukan Denda')
@section('page-title', 'Ajukan Denda')
@section('page-description', 'Buat pengajuan Denda baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Form Pengajuan Denda</h2>
                <p class="text-gray-400">Lengkapi form di bawah untuk mengajukan Denda</p>
            </div>
        </div>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="glass-card rounded-2xl p-4 border border-green-500/30 bg-green-500/10">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                <p class="text-green-300">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
            <i class="fas fa-file-alt mr-2 text-yellow-400"></i>
            Informasi Pengajuan
        </h3>

        <form action="{{ route('kronologi.add') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Judul -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-heading mr-1 text-yellow-400"></i>
                    Judul Pengajuan
                </label>
                <input type="text" name="judul" id="judul-input" value="{{ old('judul') }}"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                       placeholder="Masukkan judul pengajuan Denda" required>
                @error('judul')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Nama Barang -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-box mr-1 text-yellow-400"></i>
                    Nama Barang
                </label>
                <input type="text" name="nama_barang" id="nama-barang-input" value="{{ old('nama_barang') }}"
                       class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                       placeholder="Masukkan nama barang yang diajukan" required>
                @error('nama_barang')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Harga Barang dengan Format Titik -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-money-bill-wave mr-1 text-yellow-400"></i>
                    Harga Barang
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                    <input type="text" id="harga_display"
                           class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="0" autocomplete="off"
                           value="{{ old('harga_barang') ? number_format(old('harga_barang'), 0, ',', '.') : '' }}">
                    <!-- Hidden input untuk value asli -->
                    <input type="hidden" name="harga_barang" id="harga_value" value="{{ old('harga_barang') }}">
                </div>
                @error('harga_barang')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Periode -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-calendar-alt mr-1 text-yellow-400"></i>
                    Berapa kali bayar
                </label>
                <div class="relative">
                    <input type="number" name="periode_pelunasan" id="periode-input" value="{{ old('periode_pelunasan') }}" min="1"
                           class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="1" required>
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">x</span>
                </div>
                @error('periode_pelunasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Penjelasan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-align-left mr-1 text-yellow-400"></i>
                    Penjelasan Detail
                </label>
                <textarea name="penjelasan" id="penjelasan-input" rows="4"
                          class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                          placeholder="Jelaskan detail pengajuan Denda, alasan, dan informasi tambahan lainnya" required>{{ old('penjelasan') }}</textarea>
                @error('penjelasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('kronologi.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Ajukan Denda
                </button>
            </div>
        </form>
    </div>

    <!-- Preview Card -->
    <div class="glass-card rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-eye mr-2 text-blue-400"></i>
            Preview Pengajuan
        </h3>
        <div class="bg-gray-800/30 rounded-lg p-4">
            <div class="space-y-3">
                <div class="flex items-center">
                    <i class="fas fa-heading text-yellow-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Judul:</span>
                    <span class="text-white" id="preview-judul">-</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-box text-blue-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Barang:</span>
                    <span class="text-white" id="preview-barang">-</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-money-bill-wave text-green-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Harga:</span>
                    <span class="text-green-400 font-semibold" id="preview-harga">Rp 0</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-orange-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Periode:</span>
                    <span class="text-white" id="preview-periode">-</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calculator text-purple-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Per Bayar:</span>
                    <span class="text-purple-400 font-semibold" id="preview-per-bayar">Rp 0</span>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-align-left text-cyan-400 mr-3 w-5 mt-1"></i>
                    <span class="text-gray-400 mr-2">Penjelasan:</span>
                    <span class="text-white" id="preview-penjelasan">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Information -->
    <div class="glass-card rounded-2xl p-6 border border-blue-500/30 bg-blue-500/10">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
            <div>
                <h4 class="text-blue-400 font-semibold mb-2">Informasi Pengajuan</h4>
                <ul class="text-blue-300 text-sm space-y-1">
                    <li>• Pengajuan akan diteruskan ke Kepala Cabang untuk persetujuan pertama</li>
                    <li>• Setelah disetujui Kepala Cabang, pengajuan akan diteruskan ke Admin</li>
                    <li>• Pengajuan harus disetujui oleh kedua pihak untuk dapat diproses</li>
                    <li>• Anda dapat memantau status pengajuan di halaman riwayat</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Input elements
    const judulInput = document.getElementById('judul-input');
    const barangInput = document.getElementById('nama-barang-input');
    const hargaDisplayInput = document.getElementById('harga_display');
    const hargaValueInput = document.getElementById('harga_value');
    const periodeInput = document.getElementById('periode-input');
    const penjelasanInput = document.getElementById('penjelasan-input');

    // Preview elements
    const previewJudul = document.getElementById('preview-judul');
    const previewBarang = document.getElementById('preview-barang');
    const previewHarga = document.getElementById('preview-harga');
    const previewPeriode = document.getElementById('preview-periode');
    const previewPerBayar = document.getElementById('preview-per-bayar');
    const previewPenjelasan = document.getElementById('preview-penjelasan');

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

    // Hitung pembayaran per periode
    function calculatePerPayment() {
        const harga = parseInt(hargaValueInput.value) || 0;
        const periode = parseInt(periodeInput.value) || 1;
        return Math.ceil(harga / periode);
    }

    // Update preview harga dan perhitungan
    function updateHargaPreview() {
        const harga = parseInt(hargaValueInput.value) || 0;
        previewHarga.textContent = formatCurrency(harga);

        const perBayar = calculatePerPayment();
        previewPerBayar.textContent = formatCurrency(perBayar);
    }

    // Event listener untuk input harga dengan format real-time
    hargaDisplayInput.addEventListener('input', function(e) {
        const cursorPosition = e.target.selectionStart;
        const oldValue = e.target.value;

        // Bersihkan input dari karakter non-digit
        const cleanedValue = cleanNumber(e.target.value);

        // Set nilai asli ke hidden input
        hargaValueInput.value = cleanedValue;

        // Format untuk display
        const formattedValue = cleanedValue ? formatNumber(cleanedValue) : '';

        // Update display input
        e.target.value = formattedValue;

        // Hitung posisi cursor baru
        const dotsAdded = formattedValue.split('.').length - oldValue.split('.').length;
        const newCursorPosition = cursorPosition + dotsAdded;

        // Set posisi cursor
        setTimeout(() => {
            e.target.setSelectionRange(newCursorPosition, newCursorPosition);
        }, 0);

        // Update preview
        updateHargaPreview();
    });

    // Event listener untuk paste
    hargaDisplayInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const cleanedValue = cleanNumber(pastedText);

        hargaValueInput.value = cleanedValue;
        this.value = cleanedValue ? formatNumber(cleanedValue) : '';
        updateHargaPreview();
    });

    // Mencegah input karakter non-digit pada harga
    hargaDisplayInput.addEventListener('keydown', function(e) {
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

    // Preview update listeners
    judulInput.addEventListener('input', function() {
        previewJudul.textContent = this.value || '-';
    });

    barangInput.addEventListener('input', function() {
        previewBarang.textContent = this.value || '-';
    });

    periodeInput.addEventListener('input', function() {
        const periode = parseInt(this.value) || 0;
        previewPeriode.textContent = periode > 0 ? periode + 'x bayar' : '-';
        updateHargaPreview();
    });

    penjelasanInput.addEventListener('input', function() {
        previewPenjelasan.textContent = this.value || '-';
    });

    // Inisialisasi format jika ada nilai awal
    if (hargaValueInput.value) {
        hargaDisplayInput.value = formatNumber(hargaValueInput.value);
        updateHargaPreview();
    }

    // Inisialisasi preview awal
    if (judulInput.value) previewJudul.textContent = judulInput.value;
    if (barangInput.value) previewBarang.textContent = barangInput.value;
    if (periodeInput.value) previewPeriode.textContent = periodeInput.value + 'x bayar';
    if (penjelasanInput.value) previewPenjelasan.textContent = penjelasanInput.value;
});
</script>
@endsection
