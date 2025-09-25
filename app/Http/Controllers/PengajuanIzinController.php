<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanIzin;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Staff;
use App\Models\Absen;
use App\Models\DetailPengajuanIzin;

class PengajuanIzinController extends Controller
{
    public function view(Request $request)
    {
        // Ambil nilai filter dari query string, defaultnya 'semua'
        $filter = $request->query('filter', 'semua');

        // Query dasar
        $query = PengajuanIzin::with(['staff']);

        // Terapkan filter jika ada
        if ($filter === 'menunggu') {
            $query->where(function ($q) {
                $q->whereNull('validasi_admin')->orWhereNull('validasi_kepalacabang');
            });
        } elseif ($filter === 'ditolak') {
            $query->where(function ($q) {
                $q->where('validasi_admin', 0)->orWhere('validasi_kepalacabang', 0);
            });
        } elseif ($filter === 'diterima') {
            $query->where('validasi_admin', 1)->where('validasi_kepalacabang', 1);
        }

        // Eksekusi query
        $dataPengajuan = $query->latest()->get();

        return view('pengajuan_izin.index', compact('dataPengajuan', 'filter'));
    }

    public function addView()
    {
        return view('pengajuan_izin.add');
    }

    public function add(Request $request)
    {
        $request->validate([
            'detail' => 'required|array|min:1',
            'detail.*.tanggal' => 'required|date',
            'detail.*.status' => 'required|string|in:I,S,O,C',
            'detail.*.keterangan' => 'nullable|string|max:255',
            'detail.*.pengganti' => 'required|string|max:255',
        ]);

        $staff = Staff::where('users_id', Auth::id())->firstOrFail();
        $cabang = $staff->cabang()->first(); // ambil cabang aktif
        $cabangId = $cabang->id;
        $maxOff = $cabang->max_off_per_day ?? 999; // batas off per hari dari cabang

        // // Ambil semua tanggal pengajuan
        // $tanggalList = array_map(fn($item) => Carbon::parse($item['tanggal']), $request->detail);

        // // 1. Cek semua tanggal harus di bulan yang sama
        // $bulanPertama = $tanggalList[0]->month;
        // $bulanSama = collect($tanggalList)->every(fn($tgl) => $tgl->month === $bulanPertama);
        // if (!$bulanSama) {
        //     return back()->withErrors([
        //         'detail' => "Semua tanggal pengajuan harus berada di bulan yang sama."
        //     ])->withInput();
        // }

        // // 2. Cek selisih maksimum 14 hari
        // $minTanggal = min($tanggalList);
        // $maxTanggal = max($tanggalList);
        // $selisihHari = $minTanggal->diffInDays($maxTanggal) + 1;
        // if ($selisihHari > 14) {
        //     return back()->withErrors([
        //         'detail' => "Pengajuan tidak boleh lebih dari 14 hari (saat ini $selisihHari hari)."
        //     ])->withInput();
        // }

        // cek setiap tanggal jika status 'O'
        foreach ($request->detail as $item) {
            if ($item['status'] === 'O') {
                $tanggal = $item['tanggal'];

                $jumlahOff = PengajuanIzin::whereHas('detail_pengajuan_izin', function($q) use ($tanggal) {
                        $q->where('tanggal', $tanggal)->where('status', 'O');
                    })
                    ->where('cabang_id', $cabangId)
                    ->count();

                if ($jumlahOff >= $maxOff) {
                    return back()->withErrors([
                        'detail' => "Jumlah karyawan off di cabang ini pada tanggal $tanggal sudah mencapai batas ($maxOff orang)."
                    ])->withInput();
                }
            }
        }

        // jika lolos cek, buat pengajuan
        $pengajuan = PengajuanIzin::create([
            'staff_id' => $staff->id,
            'cabang_id' => $cabangId,
            'validasi_kepalacabang' => null,
            'kepala_id' => null,
            'validasi_admin' => null,
            'admin_id' => null
        ]);

        foreach ($request->detail as $item) {
            DetailPengajuanIzin::create([
                'pengajuan_izin_id' => $pengajuan->id,
                'tanggal' => $item['tanggal'],
                'status' => $item['status'],
                'keterangan' => $item['keterangan'],
                'pengganti' => $item['pengganti'],
            ]);
        }

        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect()->route('pengajuanizin.view')->with('success', 'Pengajuan berhasil ditambahkan.');
        } else {
            return redirect()->route('dashboard')->with('success', 'Pengajuan berhasil ditambahkan.');
        }
    }


    public function detail($id)
    {
        $user = Auth::user();
        $pengajuan = PengajuanIzin::with(['staff', 'admin', 'cabang', 'kepala', 'detail_pengajuan_izin'])->findOrFail($id);

        if ($user->role === 'karyawan' && $pengajuan->staff->users_id !== $user->id) {
            abort(403);
        }

        return view('pengajuan_izin.detail', compact('pengajuan'));
    }
    public function validasi(Request $request, $id)
    {
        $request->validate([
            'aksi' => 'required|in:terima,tolak',
        ]);

        $pengajuan = PengajuanIzin::with('detail_pengajuan_izin.staff.staffCabang')->findOrFail($id);

        $staff = Auth::user()->staff;
        $role = Auth::user()->role;

        // Ambil cabang aktif dari staff pengaju
        $staffIzin = $pengajuan->staff;
        $cabang = $staffIzin->staffCabang()->where('is_active', true)->first();
        $cabangId = $cabang->cabang_id ?? null;
        $maxOff = $cabang->cabang->max_off_per_day ?? 999;

        if ($role === 'kepala') {
            $updateData = [
                'validasi_kepalacabang' => $request->aksi === 'terima' ? 1 : 0,
                'kepala_id' => $staff->id,
            ];

            if ($request->aksi === 'tolak') {
                $updateData['keterangan'] = $request->alasan . "(Kepala Cabang)";
                $updateData['validasi_admin'] = 0;
                $updateData['admin_id'] = null;
            }

            $pengajuan->update($updateData);
        } elseif ($role === 'admin') {
            $updateData = [
                'validasi_admin' => $request->aksi === 'terima' ? 1 : 0,
                'admin_id' => $staff->id,
            ];

            if ($request->aksi === 'tolak') {
                $updateData['keterangan'] = $request->alasan . "(Admin)";
            }

            $pengajuan->update($updateData);
        }

        // Cek batas maksimal off hanya jika aksi 'terima'
        if ($request->aksi === 'terima' && $cabangId) {
            foreach ($pengajuan->detail_pengajuan_izin as $detail) {
                if ($detail->status !== 'O') continue;

                $jumlahOff = PengajuanIzin::whereHas('detail_pengajuan_izin', function($q) use ($detail) {
                        $q->where('tanggal', $detail->tanggal)->where('status', 'O');
                    })
                    ->where('cabang_id', $cabangId)
                    ->count();

                if ($jumlahOff > $maxOff) {
                    return back()->withErrors([
                        'detail' => "Jumlah karyawan off di cabang ini pada tanggal {$detail->tanggal} sudah mencapai batas ($maxOff orang)."
                    ]);
                }
            }

            // Jika lolos cek, simpan ke absen
            foreach ($pengajuan->detail_pengajuan_izin as $detail) {
                Absen::where('staff_id', $staffIzin->id)
                    ->whereDate('tanggal', $detail->tanggal)
                    ->delete();

                Absen::create([
                    'staff_id' => $staffIzin->id,
                    'cabang_id' => $cabangId,
                    'tanggal' => $detail->tanggal,
                    'status' => $detail->status,
                    'keterangan' => $detail->keterangan,
                    'pengganti' => $detail->pengganti,
                ]);
            }
        }

        return redirect()->route('pengajuanizin.detail', $id)->with('success', 'Pengajuan telah divalidasi.');
    }



    public function riwayat()
    {
        $staff = Auth::user()->staff;

        if (!$staff) {
            abort(403, 'User belum terhubung dengan data staff.');
        }

        $pengajuan = PengajuanIzin::with('detail_pengajuan_izin')
            ->where('staff_id', $staff->id)
            ->latest()
            ->get();

        $totalPengajuan = $pengajuan->count();
        $menunggu = $pengajuan->filter(fn($item) => is_null($item->validasi_admin) || is_null($item->validasi_kepalacabang))->count();
        $diterimaCount = $pengajuan->filter(fn($item) => $item->validasi_admin === 1 && $item->validasi_kepalacabang === 1)->count();
        $ditolak = $pengajuan->filter(fn($item) => $item->validasi_admin === 0 || $item->validasi_kepalacabang === 0)->count();
        $diterima = PengajuanIzin::where('staff_id', $staff->id)
            ->where('validasi_admin', 1)
            ->where('validasi_kepalacabang', 1); // Add this if needed

        return view('pengajuan_izin.riwayat', compact('pengajuan'));
    }


}
