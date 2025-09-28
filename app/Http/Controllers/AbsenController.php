<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Staff;
use App\Models\Cabang;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->query('bulan', now()->format('Y-m'));
        $cabangId = $request->query('cabang_id');


        $tanggalAwal = Carbon::parse($bulan . '-01');
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
        $jumlahHari = $tanggalAkhir->day;

        $queryStaff = Staff::with('staffCabang')
            ->whereNotNull('absen_id');

        if ($cabangId) {
            $queryStaff->whereHas('staffCabang', function ($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            });
        }

        $staffList = $queryStaff->get();
        $absenData = Absen::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])->get()->groupBy(['staff_id', function ($item) {
            return Carbon::parse($item->tanggal)->day;
        }]);

        $cabangList = Cabang::all();
        return view('absen.index', compact('bulan', 'cabangId', 'cabangList', 'staffList', 'jumlahHari', 'absenData'));
    }

    public function importForm()
    {
        return view('absen.import');
    }

    public function importProses(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'bulan' => 'required|date_format:Y-m',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        $header = $rows[2]; // Baris ke-3: header tanggal
        $data = array_slice($rows, 3); // Mulai dari baris ke-4 (index 3)
        $mapStatus = [
            'Normal'     => 'H',
            'Late'       => 'T',
            'Absent'     => 'A',
            'Off'        => 'O',
            'Leave'      => 'C',
            'Sick'       => 'S',
            'Permission' => 'I',
            'Dispensation' => 'D',
            'Early Leave' => 'E',
            'Late and Early Leave' => 'L',
        ];

        $bulan = $request->bulan;
        $tanggalBase = Carbon::parse($bulan . '-01');

        foreach ($data as $row) {
            $absenId = $row[2];
            if (!$absenId) continue;

            $staff = Staff::where('absen_id', $absenId)->first();
            if (!$staff) continue;

            // Ambil cabang aktif
            $cabangId = $staff->staffCabang()->value('cabang_id');
            if (!$cabangId) continue;

            for ($i = 4; $i <= 34; $i++) {
                $tglIndex = $i - 4;
                $tanggal = $tanggalBase->copy()->addDays($tglIndex)->toDateString();
                $statusIsi = $row[$i] ?? null;

                $status = null;
                $keterangan = null;

                // 1️⃣ Status dari Excel
                if ($statusIsi && isset($mapStatus[$statusIsi])) {
                    $status = $mapStatus[$statusIsi];
                } 
                // 2️⃣ Hari Minggu cabang 1 otomatis H
                elseif ($cabangId == 1 && Carbon::parse($tanggal)->isSunday()) {
                    $status = 'H';
                    $keterangan = 'Hari Minggu otomatis hadir';
                }

                // Kalau masih null, skip
                if (!$status) continue;

                // Skip jika absen sudah ada
                $sudahAda = Absen::where('staff_id', $staff->id)
                    ->whereDate('tanggal', $tanggal)
                    ->exists();
                if ($sudahAda) continue;

                Absen::create([
                    'staff_id' => $staff->id,
                    'cabang_id' => $cabangId,
                    'tanggal' => $tanggal,
                    'status' => $status,
                    'keterangan' => $keterangan,
                ]);
            }
        }

        return redirect()->route('absen.index')->with('success', 'Data absen berhasil diimpor, hari Minggu cabang 1 otomatis hadir jika kosong.');
    }


    public function riwayat(Request $request)
    {
        $bulan = $request->query('bulan', now()->format('Y-m'));
        $tanggalAwal = Carbon::parse($bulan . '-01')->startOfMonth();
        $tanggalAkhir = Carbon::parse($bulan . '-01')->endOfMonth();



        $staff = Staff::where('users_id', Auth::id())->firstOrFail();
        $absen = Absen::where('staff_id', $staff->id)
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('absen.riwayat', compact('absen', 'bulan'));
    }
}
