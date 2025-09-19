@extends('layouts.app')

@section('title', 'Ajukan Pinjaman')
@section('page-title', 'Ajukan Pinjaman')
@section('page-description', 'Buat pengajuan pinjaman baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="glass-card rounded-2xl p-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-white mb-2">Form Pengajuan Pinjaman</h2>
                <p class="text-gray-400">Lengkapi form di bawah untuk mengajukan pinjaman</p>
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
            <i class="fas fa-money-bill-wave mr-2 text-yellow-400"></i>
            Informasi Pinjaman
        </h3>

        <form action="{{ route('pinjaman.add') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Jumlah Pinjaman dengan Format Titik -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-money-bill-wave mr-1 text-yellow-400"></i>
                    Jumlah Pinjaman
                </label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">Rp</span>
                    <input type="text" id="jumlah_display"
                           class="w-full pl-12 pr-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="0" autocomplete="off"
                           value="{{ old('jumlah_pinjaman') ? number_format(old('jumlah_pinjaman'), 0, ',', '.') : '' }}">
                    <!-- Hidden input untuk value asli -->
                    <input type="hidden" name="jumlah_pinjaman" id="jumlah_value" value="{{ old('jumlah_pinjaman') }}">
                </div>
                @error('jumlah_pinjaman')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Periode Pelunasan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-calendar-alt mr-1 text-yellow-400"></i>
                    Periode Pelunasan
                </label>
                <select name="periode_pelunasan"
                        class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                        required>
                    <option value="">Pilih periode pelunasan</option>
                    <option value="6" {{ old('periode_pelunasan') == '6' ? 'selected' : '' }}>6 Bulan</option>
                    <option value="12" {{ old('periode_pelunasan') == '12' ? 'selected' : '' }}>12 Bulan</option>
                    <option value="18" {{ old('periode_pelunasan') == '18' ? 'selected' : '' }}>18 Bulan</option>
                    <option value="24" {{ old('periode_pelunasan') == '24' ? 'selected' : '' }}>24 Bulan</option>
                    <option value="36" {{ old('periode_pelunasan') == '36' ? 'selected' : '' }}>36 Bulan</option>
                </select>
                @error('periode_pelunasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Alasan -->
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">
                    <i class="fas fa-align-left mr-1 text-yellow-400"></i>
                    Alasan Pengajuan
                </label>
                <textarea name="alasan" rows="4"
                          class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                          placeholder="Jelaskan alasan pengajuan pinjaman..." required>{{ old('alasan') }}</textarea>
                @error('alasan')
                    <p class="text-red-400 text-sm mt-1">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6">
                <a href="{{ route('pinjaman.view') }}" class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                    Batal
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Ajukan Pinjaman
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
                    <i class="fas fa-money-bill-wave text-green-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Jumlah Pinjaman:</span>
                    <span class="text-green-400 font-semibold" id="preview-jumlah">Rp 0</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-orange-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Periode:</span>
                    <span class="text-white" id="preview-periode">-</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-calculator text-purple-400 mr-3 w-5"></i>
                    <span class="text-gray-400 mr-2">Per Bulan:</span>
                    <span class="text-purple-400 font-semibold" id="preview-per-bulan">Rp 0</span>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-align-left text-cyan-400 mr-3 w-5 mt-1"></i>
                    <span class="text-gray-400 mr-2">Alasan:</span>
                    <span class="text-white" id="preview-alasan">-</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Information -->
    <div class="glass-card rounded-2xl p-6 border border-blue-500/30 bg-blue-500/10">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
            <div>
                <h4 class="text-blue-400 font-semibold mb-2">Informasi Pinjaman</h4>
                <ul class="text-blue-300 text-sm space-y-1">
                    <li>• Proses persetujuan 1-3 hari kerja setelah pengajuan</li>
                    <li>• Pembayaran cicilan setiap tanggal yang sama setiap bulan</li>
                    <li>• Anda dapat memantau status pengajuan di halaman riwayat</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Input elements
    const jumlahDisplayInput = document.getElementById('jumlah_display');
    const jumlahValueInput = document.getElementById('jumlah_value');
    const periodeInput = document.querySelector('select[name="periode_pelunasan"]');
    const alasanInput = document.querySelector('textarea[name="alasan"]');

    // Preview elements
    const previewJumlah = document.getElementById('preview-jumlah');
    const previewPeriode = document.getElementById('preview-periode');
    const previewPerBulan = document.getElementById('preview-per-bulan');
    const previewAlasan = document.getElementById('preview-alasan');

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

    // Hitung pembayaran per bulan
    function calculatePerBulan() {
        const jumlah = parseInt(jumlahValueInput.value) || 0;
        const periode = parseInt(periodeInput.value) || 1;
        return Math.ceil(jumlah / periode);
    }

    // Update preview jumlah dan perhitungan
    function updateJumlahPreview() {
        const jumlah = parseInt(jumlahValueInput.value) || 0;
        previewJumlah.textContent = formatCurrency(jumlah);

        const perBulan = calculatePerBulan();
        previewPerBulan.textContent = formatCurrency(perBulan);
    }

    // Event listener untuk input jumlah dengan format real-time
    jumlahDisplayInput.addEventListener('input', function(e) {
        const cursorPosition = e.target.selectionStart;
        const oldValue = e.target.value;

        // Bersihkan input dari karakter non-digit
        const cleanedValue = cleanNumber(e.target.value);

        // Validasi batas maksimum
        const numValue = parseInt(cleanedValue) || 0;
        if (numValue > 100000000) {
            jumlahValueInput.value = 100000000;
            e.target.value = formatNumber(100000000);
        } else {
            jumlahValueInput.value = cleanedValue;
            e.target.value = cleanedValue ? formatNumber(cleanedValue) : '';
        }

        // Hitung posisi cursor baru
        const dotsAdded = e.target.value.split('.').length - oldValue.split('.').length;
        const newCursorPosition = cursorPosition + dotsAdded;

        // Set posisi cursor
        setTimeout(() => {
            e.target.setSelectionRange(newCursorPosition, newCursorPosition);
        }, 0);

        // Update preview
        updateJumlahPreview();
    });

    // Event listener untuk paste
    jumlahDisplayInput.addEventListener('paste', function(e) {
        e.preventDefault();
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        const cleanedValue = cleanNumber(pastedText);

        // Validasi batas maksimum
        const numValue = parseInt(cleanedValue) || 0;
        if (numValue > 100000000) {
            jumlahValueInput.value = 100000000;
            this.value = formatNumber(100000000);
        } else {
            jumlahValueInput.value = cleanedValue;
            this.value = cleanedValue ? formatNumber(cleanedValue) : '';
        }

        // Update preview
        updateJumlahPreview();
    });

    // Mencegah input karakter non-digit pada jumlah
    jumlahDisplayInput.addEventListener('keydown', function(e) {
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
    periodeInput.addEventListener('change', function() {
        const periode = parseInt(this.value) || 0;
        previewPeriode.textContent = periode > 0 ? periode + ' Bulan' : '-';
        updateJumlahPreview();
    });

    alasanInput.addEventListener('input', function() {
        previewAlasan.textContent = this.value || '-';
    });

    // Inisialisasi format jika ada nilai awal
    if (jumlahValueInput.value) {
        jumlahDisplayInput.value = formatNumber(jumlahValueInput.value);
        updateJumlahPreview();
    }

    // Inisialisasi preview awal
    if (periodeInput.value) previewPeriode.textContent = periodeInput.value + ' Bulan';
    if (alasanInput.value) previewAlasan.textContent = alasanInput.value;
});
</script>
@endsection
