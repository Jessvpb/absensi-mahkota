<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\PengajuanIzin;

class JadwalOffController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->query('bulan', now()->format('Y-m'));
        $tanggalAwal = Carbon::parse($bulan . '-01');
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
        $jumlahHari = $tanggalAkhir->day;

        // Ambil semua staff
        $staffList = Staff::with('staffCabang')->get();

        // Ambil semua pengajuan izin (khusus O = Off) dalam bulan ini
        $pengajuan = PengajuanIzin::with('detail_pengajuan_izin')
            ->whereHas('detail_pengajuan_izin', function($q) use ($tanggalAwal, $tanggalAkhir) {
                $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
                  ->where('status', 'O');
            })
            ->get();

        // Map hasil ke array [staff_id][tanggal] = status warna
        $jadwalOff = [];
        foreach ($pengajuan as $p) {
            foreach ($p->detail_pengajuan_izin as $detail) {
                if ($detail->status !== 'O') continue;

                $color = 'red'; // default menunggu
                if ($p->validasi_kepalacabang === 1 && $p->validasi_admin === 1) {
                    $color = 'green';
                } elseif ($p->validasi_kepalacabang === 1 && is_null($p->validasi_admin)) {
                    $color = 'blue';
                }

                $day = Carbon::parse($detail->tanggal)->day;
                $jadwalOff[$p->staff_id][$day] = $color;
            }
        }

        return view('jadwal_off.index', compact('bulan','jumlahHari','staffList','jadwalOff'));
    }
}
