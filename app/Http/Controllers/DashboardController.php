<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Absen;
use App\Models\SlipGaji;
use App\Models\Cabang;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function view()
    {
        $data = [];

        if (Auth::user()->role === 'admin') {
            // Admin dashboard data
            $data['totalStaff'] = Staff::where('is_active', true)->count();
            $data['cabangAktif'] = Cabang::where('is_active', true)->count();
            $data['izinHariIni'] = Absen::whereIn('status', ['I', 'S', 'C'])
                ->whereDate('tanggal', Carbon::today())
                ->distinct('staff_id')
                ->count('staff_id');
        } else {
            // Karyawan dashboard data
            $staff = Auth::user()->staff;

            if ($staff) {
                // Attendance summary for current month
                $startOfMonth = Carbon::today()->startOfMonth();
                $endOfMonth = Carbon::today()->endOfMonth();

                $izinCount = Absen::where('staff_id', $staff->id)
                    ->whereIn('status', ['I', 'S'])
                    ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                    ->count();

                $cutiCount = Absen::where('staff_id', $staff->id)
                    ->where('status', 'C')
                    ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                    ->count();

                $data['absenSummary'] = [
                    'hadir' => Absen::where('staff_id', $staff->id)
                        ->where('status', 'H')
                        ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                        ->count(),
                    'alpha' => Absen::where('staff_id', $staff->id)
                        ->where('status', 'A')
                        ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                        ->count(),
                    'terlambat' => Absen::where('staff_id', $staff->id)
                        ->where('status', 'T')
                        ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                        ->count(),
                    'izin' => $izinCount,
                    'cuti' => $cutiCount,
                ];

                // Hitung sisa jatah
                $data['sisaIzinBulanan'] = max(0, ($staff->izin_bulanan ?? 0) - $izinCount);
                $data['sisaCutiTahunan'] = max(0, ($staff->cuti_tahunan ?? 0) - $cutiCount);

                // Salary summary (get the latest salary record)
                $latestSalary = SlipGaji::where('staff_id', $staff->id)
                    ->orderBy('tanggal_penggajian', 'desc')
                    ->first();

                $data['salarySummary'] = [
                    'gaji_pokok' => $latestSalary ? $latestSalary->gaji_pokok : 0,
                    'gaji_bersih' => $latestSalary ? $latestSalary->gaji_bersih : 0,
                ];
            } else {
                // Fallback if no staff record is found
                $data['absenSummary'] = [
                    'hadir' => 0,
                    'alpha' => 0,
                    'terlambat' => 0,
                    'izin' => 0,
                    'cuti' => 0,
                ];
                $data['sisaIzinBulanan'] = 0;
                $data['sisaCutiTahunan'] = 0;
                $data['salarySummary'] = [
                    'gaji_pokok' => 0,
                    'gaji_bersih' => 0,
                ];
            }
        }

        return view('dashboard', $data);
    }


    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('Password lama salah.');
                }
            }],
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'new_password.min' => 'Password baru harus memiliki minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user(); // Ensure $user is an instance of the User model
        if (!$user instanceof \App\Models\User) {
            abort(500, 'Authenticated user is not a valid User model instance.');
        }
        $user->password = Hash::make($validated['new_password']);
        $user->save();

        return redirect()->route('dashboard')->with('success', 'Password berhasil diubah.');
    }
}
