<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Penggajian</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        h1 { text-align: center; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h1>Riwayat Penggajian</h1>
    <p class="text-center">Periode: {{ now()->format('F Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th>Nama Staff</th>
                <th>Cabang</th>
                <th class="text-right">Gaji Pokok</th>
                <th class="text-right">Tunjangan</th>
                <th class="text-right">Pot. Denda</th>
                <th class="text-right">Pot. Peminjaman</th>
                <th class="text-right">Gaji Bersih</th>
                <th>Tanggal Penggajian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payrolls as $payroll)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</td>
                    <td>{{ $payroll->staff->nama ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $payroll->cabang->nama_cabang ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($payroll->potongan_kronologi, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($payroll->potongan_hutang, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}</td>
                    <td>{{ $payroll->created_at->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada riwayat penggajian</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
