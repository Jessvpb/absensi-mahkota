<div class="overflow-x-auto">
    <table class="min-w-full border-collapse text-sm">
        <thead>
            <tr class="bg-gray-800 text-white">
                <th class="px-4 py-2 text-left">Nama Karyawan</th>
                @for ($i = 1; $i <= $jumlahHari; $i++)
                    <th class="px-2 py-2 text-center">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody class="bg-gray-900 text-white">
            @foreach ($staffList as $staff)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap">
                        <div class="font-semibold">{{ strtoupper($staff->nama) }}</div>
                        <div class="text-xs opacity-70">ID: {{ $staff->absen_id }}</div>
                    </td>
                    @for ($i = 1; $i <= $jumlahHari; $i++)
                        @php
                            $color = $jadwalOff[$staff->id][$i] ?? null;
                        @endphp
                        <td class="px-2 py-2 text-center">
                            @if ($color === 'red')
                                <span
                                    class="inline-flex w-8 h-8 rounded-full bg-red-500/20 text-red-400 border border-red-500/40 items-center justify-center font-bold">O</span>
                            @elseif ($color === 'blue')
                                <span
                                    class="inline-flex w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/40 items-center justify-center font-bold">O</span>
                            @elseif ($color === 'green')
                                <span
                                    class="inline-flex w-8 h-8 rounded-full bg-green-500/20 text-green-400 border border-green-500/40 items-center justify-center font-bold">O</span>
                            @else
                                <span
                                    class="inline-flex w-8 h-8 rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30 items-center justify-center font-bold">-</span>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Legend -->
<div class="mt-6 flex flex-wrap gap-4 items-center text-sm">
    <div class="flex items-center space-x-2">
        <span
            class="inline-flex w-8 h-8 rounded-full bg-red-500/20 text-red-400 border border-red-500/40 items-center justify-center font-bold">O</span>
        <span class="text-white">Off - Menunggu</span>
    </div>
    <div class="flex items-center space-x-2">
        <span
            class="inline-flex w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/40 items-center justify-center font-bold">O</span>
        <span class="text-white">Off - Disetujui Kepala Cabang</span>
    </div>
    <div class="flex items-center space-x-2">
        <span
            class="inline-flex w-8 h-8 rounded-full bg-green-500/20 text-green-400 border border-green-500/40 items-center justify-center font-bold">O</span>
        <span class="text-white">Off - Disetujui Kepala & Admin</span>
    </div>
    <div class="flex items-center space-x-2">
        <span
            class="inline-flex w-8 h-8 rounded-full bg-gray-500/20 text-gray-400 border border-gray-500/30 items-center justify-center font-bold">-</span>
        <span class="text-white">Tidak Ada Data</span>
    </div>
</div>

<style>
    /* Scrollbar styles */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #1f2937;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background-color: #4b5563;
        border-radius: 4px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background-color: #6b7280;
    }
</style>
