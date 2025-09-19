@props(['status'])

@php
    $colors = [
        'I' => 'bg-blue-500 text-white', // Izin
        'S' => 'bg-yellow-500 text-black', // Sakit
        'O' => 'bg-green-500 text-white', // Off
        'C' => 'bg-purple-500 text-white', // Cuti
        'D' => 'bg-red-500 text-white', // Dispensasi
        'A' => 'bg-gray-500 text-white', // Alpha
        'H' => 'bg-teal-500 text-white', // Hadir
    ];

    $labels = [
        'I' => 'Izin',
        'S' => 'Sakit',
        'O' => 'Off',
        'C' => 'Cuti',
        'D' => 'Dispensasi',
        'A' => 'Alpha',
        'H' => 'Hadir',
    ];

    $color = $colors[$status] ?? 'bg-gray-300 text-black';
    $label = $labels[$status] ?? $status;
@endphp

<span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">
    {{ $label }}
</span>
