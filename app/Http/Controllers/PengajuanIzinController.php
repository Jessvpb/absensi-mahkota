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
        $filter = $request->query('filter', 'semua');
        $query = PengajuanIzin::with(['staff', 'detail_pengajuan_izin', 'admin']);

        if ($filter === 'menunggu_kacab') {
            // Kondisi: Kacab belum isi sama sekali
            $query->whereNull('validasi_kepalacabang');

        } elseif ($filter === 'menunggu_admin') {
            // Kondisi: Kacab sudah ACC (1), tapi Admin belum isi (null)
            $query->where('validasi_kepalacabang', 1)
                ->whereNull('validasi_admin');

        } elseif ($filter === 'ditolak') {
            // Kondisi: Salah satu menolak (0)
            $query->where(function ($q) {
                $q->where('validasi_admin', 0)
                ->orWhere('validasi_kepalacabang', 0);
            });

        } elseif ($filter === 'acc') {
            // Kondisi: Dua-duanya sudah ACC (1)
            $query->where('validasi_admin', 1)
                ->where('validasi_kepalacabang', 1);
        }

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
            'detail.*.status' => 'required|string|in:I,S,O,C',
            'detail.*.keterangan' => 'nullable|string|max:255',
            'detail.*.pengganti' => 'required|string|max:255',
        ]);

        $staff = Staff::where('users_id', Auth::id())->firstOrFail();
        $cabang = $staff->cabang()->first(); 
        $cabangId = $cabang->id;

        // buat pengajuan
        $pengajuan = PengajuanIzin::create([
            'staff_id' => $staff->id,
            'cabang_id' => $cabangId,
            'validasi_kepalacabang' => null,
            'kepala_id' => null,
            'validasi_admin' => null,
            'admin_id' => null
        ]);

        foreach ($request->detail as $item) {
            if ($item['status'] === 'C' && isset($item['tanggal_awal'], $item['tanggal_akhir'])) {
                $start = Carbon::parse($item['tanggal_awal']);
                $end   = Carbon::parse($item['tanggal_akhir']);

                if ($end->lt($start)) {
                    return back()->withErrors([
                        'detail' => "Tanggal akhir cuti tidak boleh lebih awal dari tanggal awal."
                    ])->withInput();
                }

                for ($date = $start; $date->lte($end); $date->addDay()) {
                    DetailPengajuanIzin::create([
                        'pengajuan_izin_id' => $pengajuan->id,
                        'tanggal' => $date->format('Y-m-d'),
                        'status' => $item['status'],
                        'keterangan' => $item['keterangan'],
                        'pengganti' => $item['pengganti'],
                    ]);
                }
            } else {
                DetailPengajuanIzin::create([
                    'pengajuan_izin_id' => $pengajuan->id,
                    'tanggal' => $item['tanggal'],
                    'status' => $item['status'],
                    'keterangan' => $item['keterangan'],
                    'pengganti' => $item['pengganti'],
                ]);
            }
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

        $pengajuan = PengajuanIzin::with([
            'staff', 
            'admin', 
            'kepala', 
            'cabang', 
            'detail_pengajuan_izin.pengajuan_izin.staff'
        ])->findOrFail($id);

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

        $staffApprove = Auth::user()->staff; // Staff yang sedang login/melakukan acc
        $role = Auth::user()->role;

        $staffIzin = $pengajuan->staff;
        $cabang = $staffIzin->staffCabang()->where('is_active', true)->first();
        $cabangId = $cabang->cabang_id ?? null;
        $maxOff = $cabang->cabang->max_off_per_day ?? 999;

        if ($role === 'kepala') {
            $updateData = [
                'validasi_kepalacabang' => $request->aksi === 'terima' ? 1 : 0,
                'kepala_id' => $staffApprove->id,
                'tgl_validasi_kepala' => now(), // PENAMBAHAN: Catat waktu Kacab
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
                'admin_id' => $staffApprove->id,
                'tgl_validasi_admin' => now(), // PENAMBAHAN: Catat waktu Admin
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
                    ->where('validasi_admin', 1)
                    ->where('validasi_kepalacabang', 1)
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
        if (!$staff) abort(403, 'User belum terhubung dengan data staff.');

        $pengajuan = PengajuanIzin::with('detail_pengajuan_izin')
            ->where('staff_id', $staff->id)
            ->latest()
            ->get();

        return view('pengajuan_izin.riwayat', compact('pengajuan'));
    }
}