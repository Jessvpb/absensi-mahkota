@extends('layouts.app')

@section('title', 'Penggajian Staff')
@section('page-title', 'Penggajian Staff')
@section('page-description', 'Kelola dan proses penggajian karyawan Mahkota Gallery')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="glass-card rounded-2xl p-4 border border-green-500/30 bg-green-500/10 flex items-center">
                <i class="fas fa-check-circle text-green-400 mr-3"></i>
                <p class="text-green-300">{{ session('success') }}</p>
            </div>
        @endif

        <div class="glass-card rounded-2xl p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Penggajian Staff</h2>
                    <p class="text-gray-400">Klik nama staff untuk melihat rincian potongan & slip gaji.</p>
                </div>
                @if ($staff->isNotEmpty())
                    <form method="GET" action="{{ route('slip.proses') }}" id="payrollForm"
                        class="flex flex-col lg:flex-row gap-4">
                        <select name="month"
                            class="px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ now()->month == $i ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="year"
                            class="px-4 py-3 bg-gray-800/50 border border-gray-600/50 rounded-xl text-white focus:border-yellow-400">
                            @for ($i = 2025; $i <= 2030; $i++)
                                <option value="{{ $i }}" {{ now()->year == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:scale-105 transition-all">
                            <i class="fas fa-money-bill-wave mr-2"></i> Proses Gaji
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="glass-card rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead
                        class="bg-gray-800/50 border-b border-gray-700/50 text-gray-300 uppercase text-sm tracking-wider">
                        <tr>
                            <th class="px-6 py-5">Staff (Klik untuk Detail)</th>
                            <th class="px-6 py-5">Cabang</th>
                            <th class="px-6 py-5 text-right text-yellow-400">Gaji Bersih</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700/50">
                        @forelse($staff as $s)
                            <tr class="hover:bg-yellow-400/5 transition-all duration-200 group">
                                <td class="px-6 py-4">
                                    <a href="{{ route('slip.detail', $s->id) }}" class="flex items-center group">
                                        <div
                                            class="w-12 h-12 bg-gradient-to-br from-yellow-400/10 to-amber-600/10 rounded-2xl flex items-center justify-center mr-4 group-hover:from-yellow-400 group-hover:to-amber-500 transition-all shadow-inner border border-yellow-400/20">
                                            <i
                                                class="fas fa-user-tie text-yellow-400 group-hover:text-black transition-colors"></i>
                                        </div>
                                        <div>
                                            <div
                                                class="text-white font-bold text-lg group-hover:text-yellow-400 transition-colors">
                                                {{ $s->nama }}</div>
                                            <div class="text-xs text-gray-500 font-medium tracking-widest uppercase">Lihat
                                                Rincian Potongan →</div>
                                        </div>
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 bg-purple-500/10 text-purple-400 border border-purple-500/20 rounded-lg text-sm font-bold">
                                        {{ $s->cabang[0]->nama_cabang ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-green-400 font-black text-xl font-mono">
                                        Rp {{ number_format($s->gaji_bersih, 0, ',', '.') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">Data staff tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
