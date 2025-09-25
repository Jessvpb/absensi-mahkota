<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanDispensasi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Absen;
use App\Models\DetailPengajuanDispensasi;

class PengajuanDispensasiController extends Controller
{
    public function view(Request $request)
    {
        // Ambil nilai filter dari query string, defaultnya 'semua'
        $filter = $request->query('filter', 'semua');

        // Query dasar
        $query = PengajuanDispensasi::with(['staff', 'admin']);

        // Terapkan filter jika ada
        if ($filter === 'menunggu') {
            $query->whereNull('validasi_admin');
        } elseif ($filter === 'acc') {
            $query->where('validasi_admin', 1);
        } elseif ($filter === 'ditolak') {
            $query->where('validasi_admin', 0);
        }

        // Eksekusi query
        $dataPengajuan = $query->latest()->get();

        return view('pengajuan_dispensasi.index', compact('dataPengajuan', 'filter'));
    }

    public function addView()
    {
        return view('pengajuan_dispensasi.add');
    }

    public function add(Request $request)
    {
        $request->validate([
            'detail' => 'required|array|min:1',
            'detail.*.tanggal' => 'required|date',
            'detail.*.keterangan' => 'nullable|string|max:255',
        ]);

        $staff = Staff::where('users_id', Auth::id())->firstOrFail();

        // // Ambil semua tanggal pengajuan dan ubah ke Carbon
        // $tanggalList = array_map(fn($item) => Carbon::parse($item['tanggal']), $request->detail);

        // // 1. Cek semua tanggal harus di bulan yang sama
        // $bulanPertama = $tanggalList[0]->month;
        // $bulanSama = collect($tanggalList)->every(fn($tgl) => $tgl->month === $bulanPertama);
        // if (!$bulanSama) {
        //     return back()->withErrors([
        //         'detail' => "Semua tanggal pengajuan dispensasi harus berada di bulan yang sama."
        //     ])->withInput();
        // }

        // // 2. Cek selisih maksimum 14 hari
        // $minTanggal = min($tanggalList);
        // $maxTanggal = max($tanggalList);
        // $selisihHari = $minTanggal->diffInDays($maxTanggal) + 1;
        // if ($selisihHari > 14) {
        //     return back()->withErrors([
        //         'detail' => "Pengajuan dispensasi tidak boleh lebih dari 14 hari (saat ini $selisihHari hari)."
        //     ])->withInput();
        // }

        // Jika lolos pengecekan, buat pengajuan
        $pengajuan = PengajuanDispensasi::create([
            'staff_id' => $staff->id,
            'validasi_admin' => null,
            'admin_id' => null
        ]);

        foreach ($request->detail as $item) {
            DetailPengajuanDispensasi::create([
                'pengajuan_dispensasi_id' => $pengajuan->id,
                'tanggal' => $item['tanggal'],
                'status' => 'D',
                'keterangan' => $item['keterangan'],
            ]);
        }

        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('pengajuandispensasi.view')->with('success', 'Pengajuan berhasil ditambahkan.');
        } else {
            return redirect()->route('dashboard')->with('success', 'Pengajuan berhasil ditambahkan.');
        }
    }

    public function detail($id)
    {
        $user = Auth::user();
        $pengajuan = PengajuanDispensasi::with(['staff', 'admin', 'detail_pengajuan_dispensasi'])->findOrFail($id);

        if ($user->role !== 'admin') {
            $staff = $user->staff;

            // Kalau user belum punya relasi staff atau bukan pemilik pengajuan ini, tolak
            if (!$staff || $pengajuan->staff_id !== $staff->id) {
                abort(403, 'Anda tidak didispensasikan mengakses data ini.');
            }
        }

        return view('pengajuan_dispensasi.detail', compact('pengajuan'));
    }
    public function validasi(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:terima,tolak',
        ]);

        $pengajuan = PengajuanDispensasi::with('detail_pengajuan_dispensasi')->findOrFail($id);

        $staff = Auth::user()->staff;
        if (!$staff) {
            abort(403, 'User ini tidak terhubung dengan data staff.');
        }

        $pengajuan->validasi_admin = $request->aksi === 'terima' ? 1 : 0;
        $pengajuan->admin_id = $staff->id;
        $pengajuan->save();

        if ($request->aksi === 'terima') {
            $staffDispensasi = $pengajuan->staff;
            $cabangId = $staffDispensasi->staffCabang()->where('is_active', true)->value('cabang_id');

            if ($cabangId) {
                foreach ($pengajuan->detail_pengajuan_dispensasi as $detail) {
                    // Hapus data absen yang sudah ada di tanggal itu
                    Absen::where('staff_id', $staffDispensasi->id)
                        ->whereDate('tanggal', $detail->tanggal)
                        ->delete();

                    // Masukkan data absen dari pengajuan
                    Absen::create([
                        'staff_id' => $staffDispensasi->id,
                        'cabang_id' => $cabangId,
                        'tanggal' => $detail->tanggal,
                        'status' => $detail->status,
                        'keterangan' => $detail->keterangan,
                    ]);
                }
            }
        }

        return redirect()->route('pengajuandispensasi.detail', $id)->with('success', 'Pengajuan telah divalidasi.');
    }


    public function riwayat()
    {
        $staff = Auth::user()->staff;

        if (!$staff) {
            abort(403, 'User belum terhubung dengan data staff.');
        }

        $pengajuan = PengajuanDispensasi::with('detail_pengajuan_dispensasi')
            ->where('staff_id', $staff->id)
            ->latest()
            ->get();

        return view('pengajuan_dispensasi.riwayat', compact('pengajuan'));
    }


}
