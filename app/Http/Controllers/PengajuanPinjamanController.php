<?php

namespace App\Http\Controllers;

use App\Models\DetailHutang;
use Illuminate\Http\Request;
use App\Models\PengajuanPinjaman;
use App\Models\Hutang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class PengajuanPinjamanController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $data = $user->role === 'karyawan'
            ? PengajuanPinjaman::where('staff_id', $user->staff->id)->get()
            : PengajuanPinjaman::with('staff')->latest()->get();

        return view('pengajuan_pinjaman.index', compact('data'));
    }
    public function addView()
    {
        return view('pengajuan_pinjaman.add');
    }
    public function add(Request $request)
    {
        // Set start pelunasan bulan depan
        $startPelunasan = Carbon::now()->addMonthNoOverflow()->startOfMonth();

        $request->validate([
            'jumlah_pinjaman' => 'required|numeric|min:1000',
            'alasan' => 'required|string',
        ]);

        PengajuanPinjaman::create([
            'staff_id' => Auth::user()->staff->id,
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'periode_pelunasan' => $request->periode_pelunasan,
            'start_pelunasan' => $startPelunasan,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('pinjaman.addView')->with('success', 'Pengajuan pinjaman berhasil dikirim.');
    }
    public function validasi(Request $request, $id)
    {
        $request->validate(['aksi' => 'required|in:terima,tolak']);
        $pengajuan = PengajuanPinjaman::findOrFail($id);

        $pengajuan->update([
            'validasi_admin' => $request->aksi === 'terima' ? 1 : 0,
            'admin_id' => Auth::user()->staff->id,
        ]);

        if ($request->aksi === 'terima') {
            // Set start pelunasan bulan depan
            $startPelunasan = Carbon::now()->addMonthNoOverflow()->startOfMonth();

            $hutangbaru = Hutang::create([
                'staff_id' => $pengajuan->staff_id,
                'jumlah_hutang' => $pengajuan->jumlah_pinjaman,
                'periode_pelunasan' => $pengajuan->periode_pelunasan,
                'start_pelunasan' => $startPelunasan,
                'sisa_hutang' => $pengajuan->jumlah_pinjaman,
                'jenis' => 'pinjam',
                'pinjaman_id' => $pengajuan->id,
                'status' => 'ONGOING',
            ]);
        }

        // Hitung cicilan per bulan
        $jumlahPerBulan = round($pengajuan->jumlah_pinjaman/ $pengajuan->periode_pelunasan, 2);

        for ($i = 0; $i < $pengajuan->periode_pelunasan; $i++) {
            DetailHutang::create([
                'hutang_id' => $hutangbaru->id,
                'jumlah_hutang' => $jumlahPerBulan,
                'tanggal_pelunasan' => $startPelunasan->copy()->addMonths($i),
            ]);
        }

        return redirect()->route('pinjaman.view')->with('success', 'Validasi berhasil dilakukan.');
    }

    public function detail($id)
    {
        $pinjaman = PengajuanPinjaman::with(['staff', 'cabang', 'kepala', 'admin'])->findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'karyawan' && $pinjaman->staff->users_id !== $user->id) {
            abort(403);
        }

        return view('pengajuan_pinjaman.detail', compact('pinjaman'));
    }

    public function riwayat()
    {
        $staff = Auth::user()->staff;
        $pengajuan = PengajuanPinjaman::where('staff_id', $staff->id)->latest()->get();
        return view('pengajuan_pinjaman.riwayat', compact('pengajuan'));
    }
}
