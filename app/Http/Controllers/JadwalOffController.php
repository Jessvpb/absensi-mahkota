<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\PengajuanIzin;
use App\Models\Cabang;

class JadwalOffController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->query('bulan', now()->format('Y-m'));
        $cabangId = $request->query('cabang_id'); // dari filter

        $tanggalAwal = Carbon::parse($bulan . '-01');
        $tanggalAkhir = $tanggalAwal->copy()->endOfMonth();
        $jumlahHari = $tanggalAkhir->day;

        // Ambil semua cabang untuk filter
        $cabangList = Cabang::all();

        // Ambil staff, bisa filter berdasarkan cabang
        $staffQuery = Staff::with('staffCabang');
        if ($cabangId) {
            $staffQuery->whereHas('staffCabang', function($q) use ($cabangId) {
                $q->where('cabang_id', $cabangId);
            });
        }
        $staffList = $staffQuery->get();

        // Kelompokkan staff per cabang
        $staffPerCabang = [];
        foreach ($cabangList as $cabang) {
            $staffPerCabang[$cabang->id] = $staffList->filter(function($staff) use ($cabang) {
                return $staff->staffCabang->contains('cabang_id', $cabang->id);
            })->values(); // reset keys
        }

        // Ambil pengajuan izin khusus O = Off dalam bulan ini
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

        // Kirim semua variabel ke view
        return view('jadwaloff.index', compact('bulan','jumlahHari','staffPerCabang','jadwalOff','cabangList','cabangId'));
    }
}
