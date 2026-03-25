<?php

namespace App\Exports;

use App\Models\Absen;
use App\Models\Cabang;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromArray, ShouldAutoSize, WithStyles
{
    protected $month, $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function array(): array
    {
        $data = [];
        // Ambil semua cabang
        $allCabang = Cabang::all();

        foreach ($allCabang as $cabang) {
            // 1. Tambahkan Nama Cabang sebagai Judul Tabel
            $data[] = ['CABANG: ' . strtoupper($cabang->nama_cabang)];
            
            // 2. Tambahkan Header Tabel untuk Cabang ini
            $data[] = ['Tanggal', 'Nama Karyawan', 'Jam Masuk', 'Jam Pulang', 'Status', 'Keterangan'];

            // 3. Ambil data absen filter per cabang dan bulan
            // Menggunakan relasi staff.cabang agar lebih ringkas
            $absens = Absen::with('staff')
                ->whereMonth('tanggal', $this->month)
                ->whereYear('tanggal', $this->year)
                ->whereHas('staff.cabang', function($q) use ($cabang) {
                    $q->where('cabangs.id', $cabang->id);
                })
                ->orderBy('tanggal', 'asc')
                ->get();

            if ($absens->isEmpty()) {
                $data[] = ['Tidak ada data absensi untuk bulan ini'];
            } else {
                foreach ($absens as $absen) {
                    $data[] = [
                        $absen->tanggal,
                        $absen->staff->nama ?? '-',
                        $absen->jam_masuk ?? '-',
                        $absen->jam_pulang ?? '-',
                        $this->getStatusLabel($absen->status),
                        $absen->keterangan ?? '-'
                    ];
                }
            }

            // 4. Tambahkan 2 baris kosong sebagai pemisah antar tabel cabang
            $data[] = []; 
            $data[] = []; 
        }

        return $data;
    }

    private function getStatusLabel($status)
    {
        $labels = [
            'H' => 'Hadir', 
            'A' => 'Alpha', 
            'I' => 'Izin', 
            'S' => 'Sakit', 
            'T' => 'Terlambat', 
            'O' => 'Off'
        ];
        return $labels[$status] ?? $status;
    }

    public function styles(Worksheet $sheet)
    {
        // Mencari baris yang berisi tulisan "CABANG:" untuk ditebalkan otomatis
        $highestRow = $sheet->getHighestRow();
        $styles = [];

        for ($i = 1; $i <= $highestRow; $i++) {
            $cellValue = $sheet->getCell('A' . $i)->getValue();
            if (str_contains((string)$cellValue, 'CABANG:')) {
                $styles[$i] = ['font' => ['bold' => true, 'size' => 12]];
            }
        }

        return $styles;
    }
}