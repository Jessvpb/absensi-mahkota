<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Slip Gaji Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #eee;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        /* Header dengan 3 bagian: kiri (kosong/nama nip), tengah (judul), kanan (logo+perusahaan) */
        .header {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: start;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .header-center {
            text-align: center;
        }

        .header-center h1 {
            font-size: 28px;
            margin: 0;
            font-weight: bold;
            color: #000;
        }

        .header-right {
            text-align: right;
        }

        .header-right img {
            width: 120px;
            height: auto;
            margin-bottom: 6px;
        }

        .header-right p {
            margin: 0;
            line-height: 1.4;
            font-size: 12px;
        }

        .employee-details {
            margin-top: 10px;
            text-align: left;
            font-size: 13px;
        }

        .employee-details p {
            margin: 3px 0;
        }

        .main-content {
            display: flex;
            margin-bottom: 30px;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .section {
            flex: 1;
            padding: 0;
        }

        .section:first-child {
            border-right: 1px solid #ddd;
        }

        .section h2 {
            background-color: #f2f2f2;
            margin: 0;
            padding: 8px 10px;
            font-size: 14px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .item-list {
            padding: 10px;
        }

        .item {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
        }

        .item-amount {
            text-align: right;
            width: 100px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 10px;
            font-weight: bold;
            background-color: #f2f2f2;
            border-top: 1px solid #ddd;
        }

        .footer {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .footer-right {
            text-align: center;
            border: 1px solid #000;
            padding: 10px;
        }

        .footer-right p {
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .footer-right .total-amount-box {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            color: #000;
            padding: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">

        <!-- Header -->
        <div class="header">
            <div></div> <!-- kosong (biar grid center jalan) -->

            <!-- Tengah -->
            <div class="header-center">
                <h1>Slip Gaji</h1>
            </div>

            <!-- Kanan -->
            <div class="header-right">
                <img src="{{ $logoBase64 }}" alt="Logo">
                <p style="font-weight:bold; font-size:14px;">Mahkota Gallery</p>
                <p>Jl. Dempo Luar No.968, 15 Ilir, Kec. Ilir Tim. I</p>
                <p>Kota Palembang, Sumatera Selatan 30111</p>
                <p>Palembang, Indonesia</p>
            </div>
        </div>

        <!-- Nama / NIP / Periode di bawah kiri -->
        <div class="employee-details">
            <p><strong>Nama:</strong> {{ $payroll->staff->nama ?? 'Tidak Diketahui' }}</p>
            <p><strong>NIP:</strong> {{ $payroll->staff->NIP ?? 'ZM0001' }}</p>
            <p><strong>Periode:</strong> {{ \Carbon\Carbon::parse($payroll->periode)->format('F Y') }}</p>
        </div>

        <!-- Konten utama -->
        <div class="main-content">
            <div class="section">
                <h2>Pendapatan</h2>
                <div class="item-list">
                    <div class="item">
                        <span>Gaji Pokok</span>
                        <span class="item-amount">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</span>
                    </div>
                    <div class="item">
                        <span>Tunjangan</span>
                        <span class="item-amount">Rp {{ number_format($payroll->gaji_tunjangan, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="total-row">
                    <span>Total Pendapatan</span>
                    <span class="amount">Rp
                        {{ number_format($payroll->gaji_pokok + $payroll->gaji_tunjangan, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="section">
                <h2>Potongan</h2>
                <div class="item-list">
                    <div class="item"><span>Potongan Denda</span><span class="item-amount">Rp
                            {{ number_format($payroll->potongan_kronologi, 0, ',', '.') }}</span></div>
                    <div class="item"><span>Potongan Peminjaman</span><span class="item-amount">Rp
                            {{ number_format($payroll->potongan_hutang, 0, ',', '.') }}</span></div>
                    <div class="item"><span>Potongan Izin</span><span class="item-amount">Rp
                            {{ number_format($payroll->potongan_izin, 0, ',', '.') }}</span></div>
                    <div class="item"><span>Potongan Alpha</span><span class="item-amount">Rp
                            {{ number_format($payroll->potongan_alpha, 0, ',', '.') }}</span></div>
                    <div class="item"><span>Potongan Terlambat</span><span class="item-amount">Rp
                            {{ number_format($payroll->potongan_terlambat, 0, ',', '.') }}</span></div>
                </div>
                <div class="total-row">
                    <span>Total Potongan</span>
                    <span class="amount">Rp
                        {{ number_format($payroll->potongan_kronologi + $payroll->potongan_hutang + $payroll->potongan_izin + $payroll->potongan_alpha + $payroll->potongan_terlambat, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Hak cuti & izin -->
        <div class="section" style="margin-top:20px; border:1px solid #ddd;">
            <h2>Hak Cuti & Izin</h2>
            <div class="total-row">
                <span>Sisa Izin Bulanan</span>
                <span>{{ max(0, ($payroll->staff->izin_bulanan ?? 0) - ($payroll->absen_details['izin_days'] ?? 0)) }}
                    Hari</span>
            </div>
            <div class="total-row">
                <span>Sisa Cuti Tahunan</span>
                <span>{{ max(0, ($payroll->staff->cuti_tahunan ?? 0) - ($payroll->absen_details['cuti_days'] ?? 0)) }}
                    Hari</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="footer-right">
                <p>Total Penerimaan Bulan Ini</p>
                <div class="total-amount-box">
                    Rp {{ number_format($payroll->gaji_bersih, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
