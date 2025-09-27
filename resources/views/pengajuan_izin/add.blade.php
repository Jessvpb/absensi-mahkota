@extends('layouts.app')

@section('title', 'Ajukan Izin')
@section('page-title', 'Ajukan Izin')
@section('page-description', 'Buat pengajuan izin baru')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="glass-card rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Form Pengajuan Izin</h2>
                    <p class="text-gray-400">Lengkapi form di bawah untuk mengajukan izin</p>
                </div>
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
        <div class="glass-card rounded-2xl p-6">
            <h3 class="text-xl font-semibold text-white mb-6 flex items-center">
                <i class="fas fa-calendar-plus mr-2 text-white"></i>
                Detail Pengajuan Izin
            </h3>

            <form method="POST" action="{{ route('pengajuanizin.add') }}" class="space-y-6">
                @csrf

                <div id="detail-container" class="space-y-4">
                    <label class="block text-sm font-medium text-gray-300 mb-4">
                        <i class="fas fa-list mr-1 text-yellow-400"></i>
                        Detail Hari Izin
                    </label>

                    <div class="detail-row bg-gray-800/30 rounded-xl p-4 border border-gray-700/50">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                                <select name="detail[0][status]"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                                    required>
                                    <option value="">Pilih Status</option>
                                    <option value="I">🏠 Izin</option>
                                    <option value="S">🤒 Sakit</option>
                                    <option value="C">🏖️ Cuti</option>
                                    <option value="O">📅 Off</option>
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal</label>
                                <input type="date" name="detail[0][tanggal]"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                    required>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Keterangan</label>
                                <input type="text" name="detail[0][keterangan]"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                                    placeholder="Masukkan keterangan (opsional)">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-300 mb-2">Pengganti</label>
                                <input type="text" name="detail[0][pengganti]"
                                    class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                                    placeholder="Masukkan nama pengganti (opsional)">
                            </div>
                            <div class="md:col-span-1">
                                <button type="button"
                                    class="w-full px-3 py-3 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition-colors duration-200 border border-red-500/30 btn-remove">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button type="button" id="btn-add"
                        class="inline-flex items-center px-4 py-3 bg-blue-500/20 text-blue-400 rounded-xl hover:bg-blue-500/30 transition-colors duration-200 border border-blue-500/30">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Hari
                    </button>

                    <div class="flex items-center space-x-4">
                        <a href="{{ route('pengajuanizin.view') }}"
                            class="px-6 py-3 bg-gray-600/50 text-gray-300 rounded-xl hover:bg-gray-600/70 transition-colors duration-200">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-black font-semibold rounded-xl hover:from-yellow-500 hover:to-amber-600 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-yellow-400/25">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Ajukan Izin
                        </button>
                    </div>
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
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-400 text-sm">Total Hari Izin</p>
                        <p class="text-2xl font-bold text-white" id="total-days">0 Hari</p>
                    </div>

                    <div
                        class="w-12 h-12 bg-gradient-to-br from-purple-400/20 to-purple-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-calendar-days text-white"></i>
                    </div>
                </div>
                <div id="preview-list" class="space-y-2">
                    <p class="text-gray-500 italic">Belum ada hari yang dipilih</p>
                </div>
            </div>
        </div>

        <!-- Information -->
        <div class="glass-card rounded-2xl p-6 border border-blue-500/30 bg-blue-500/10">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-400 mr-3 mt-1"></i>
                <div>
                    <h4 class="text-blue-400 font-semibold mb-2">Informasi Pengajuan Izin</h4>
                    <ul class="text-blue-300 text-sm space-y-1">
                        <li>• <strong>Izin (I):</strong> Untuk keperluan pribadi yang tidak dapat ditunda</li>
                        <li>• <strong>Sakit (S):</strong> Untuk kondisi kesehatan yang tidak memungkinkan bekerja</li>
                        <li>• <strong>Cuti (C):</strong> Untuk liburan atau istirahat yang telah direncanakan</li>
                        <li>• <strong>Off (O):</strong> Untuk hari libur tambahan atau kompensasi</li>
                        <li>• Pengajuan akan diteruskan ke Admin untuk persetujuan</li>
                        <li>• Anda dapat memantau status pengajuan di halaman riwayat</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('detail-container');
            const btnAdd = document.getElementById('btn-add');
            const totalDaysElement = document.getElementById('total-days');
            const previewList = document.getElementById('preview-list');
            let index = 1;

            function updatePreview() {
                const rows = container.querySelectorAll('.detail-row');
                const totalDays = rows.length;
                totalDaysElement.textContent = `${totalDays} Hari`;

                if (totalDays === 0) {
                    previewList.innerHTML = '<p class="text-gray-500 italic">Belum ada hari yang dipilih</p>';
                    return;
                }

                let previewHTML = '';
                rows.forEach((row, index) => {
                    const tanggal = row.querySelector('input[type="date"]').value;
                    const status = row.querySelector('select').value;
                    const keterangan = row.querySelector('input[type="text"]').value;

                    if (tanggal && status) {
                        const statusLabels = {
                            'I': '🏠 Izin',
                            'S': '🤒 Sakit',
                            'C': '🏖️ Cuti',
                            'O': '📅 Off'
                        };

                        const date = new Date(tanggal);
                        const formattedDate = date.toLocaleDateString('id-ID', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });

                        previewHTML += `
                    <div class="flex items-center justify-between p-3 bg-gray-700/30 rounded-lg">
                        <div>
                            <p class="text-white font-medium">${formattedDate}</p>
                            <p class="text-gray-400 text-sm">${statusLabels[status] || status}${keterangan ? ' - ' + keterangan : ''}</p>
                        </div>
                        <span class="text-yellow-400 font-semibold">${index + 1}</span>
                    </div>
                `;
                    }
                });

                previewList.innerHTML = previewHTML ||
                    '<p class="text-gray-500 italic">Lengkapi data untuk melihat preview</p>';
            }

            btnAdd.addEventListener('click', () => {
                const row = document.createElement('div');
                row.classList.add('detail-row', 'bg-gray-800/30', 'rounded-xl', 'p-4', 'border',
                    'border-gray-700/50');

                row.innerHTML = `
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                    <select name="detail[${index}][status]"
                            class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                        <option value="">Pilih Status</option>
                        <option value="I">🏠 Izin</option>
                        <option value="S">🤒 Sakit</option>
                        <option value="C">🏖️ Cuti</option>
                        <option value="O">📅 Off</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Tanggal</label>
                    <input type="date" name="detail[${index}][tanggal]"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all" required>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Keterangan</label>
                    <input type="text" name="detail[${index}][keterangan]"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan keterangan (opsional)">
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-300 mb-2">Pengganti</label>
                    <input type="text" name="detail[0][pengganti]"
                           class="w-full px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white placeholder-gray-400 focus:border-yellow-400 focus:ring-2 focus:ring-yellow-400/20 transition-all"
                           placeholder="Masukkan nama pengganti (opsional)">
                </div>
                <div class="md:col-span-1">
                    <button type="button" class="w-full px-3 py-3 bg-red-500/20 text-red-400 rounded-xl hover:bg-red-500/30 transition-colors duration-200 border border-red-500/30 btn-remove">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
                container.appendChild(row);
                index++;
                updatePreview();

                // Add event listeners to new inputs
                row.querySelectorAll('input, select').forEach(input => {
                    input.addEventListener('change', updatePreview);
                });
            });

            container.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-remove') || e.target.closest('.btn-remove')) {
                    const row = e.target.closest('.detail-row');
                    if (container.querySelectorAll('.detail-row').length > 1) {
                        row.remove();
                        updatePreview();
                    } else {
                        alert('Minimal harus ada satu hari izin');
                    }
                }
            });

            // Add event listeners to initial inputs
            container.addEventListener('change', updatePreview);

            updatePreview();
        });
    </script>

    <style>
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(100%);
        }
    </style>
@endsection
