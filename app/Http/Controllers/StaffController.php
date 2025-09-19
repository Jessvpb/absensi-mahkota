<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\Cabang;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    public function view(Request $request)
    {
        $query = Staff::with([
            'cabang' => function ($q) {
                $q->orderByDesc('staff_cabang.created_at');
            },
            'jabatan' => function ($q) {
                $q->orderByDesc('staff_jabatan.created_at');
            }
        ]);

        // Define $search with a default value
        $search = $request->query('search', '');

        // Filter berdasarkan status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Filter berdasarkan cabang
        if ($request->filled('cabang_id')) {
            $query->whereHas('cabang', function ($q) use ($request) {
                $q->where('cabang.id', $request->cabang_id);
            });
        }

        // Filter berdasarkan jabatan
        if ($request->filled('jabatan_id')) {
            $query->whereHas('jabatan', function ($q) use ($request) {
                $q->where('jabatan.id', $request->jabatan_id);
            });
        }

        // Pencarian berdasarkan nama, NIP, nomor telepon, atau alamat
        if ($request->filled('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('NIP', 'like', '%' . $search . '%')
                    ->orWhere('notel', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%');
            });
        }

        $staff = $query->get();
        $cabang = Cabang::where('is_active', '=', '1')->get();
        $jabatan = Jabatan::where('is_active', '=', '1')->get();

        return view('staff.index', compact('staff', 'cabang', 'jabatan', 'search'));
    }
    public function addView()
    {
        $cabang = Cabang::where('is_active', '=', '1')->get();
        $jabatan = Jabatan::where('is_active', '=', '1')->get();
        return view('staff.add', compact('cabang', 'jabatan'));
    }
    public function add(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'NIP' => 'required|string|max:12|unique:staff,NIP',
            'absen_id' => 'required|string|max:50|unique:staff,absen_id',
            'nama' => 'required|string|max:255',
            'JK' => 'required|in:L,P',
            'TTL' => 'required|date',
            'notel' => 'required|string|max:20',
            'alamat' => 'required|string',
            'tgl_masuk' => 'required|date',
            'tgl_keluar' => 'nullable|date|after_or_equal:tgl_masuk',
            'gaji_pokok' => 'required|numeric|min:0',
            'gaji_tunjangan' => 'nullable|numeric|min:0',
            'is_active' => 'required|boolean',
            'cabang_id' => 'required|exists:cabang,id',
            'jabatan_id' => 'required|exists:jabatan,id',
        ], [
            'NIP.max' => 'NIP tidak boleh lebih dari 12 karakter.', // Pesan error kustom untuk max:12
        ]);

        // Set default nilai gaji_tunjangan ke 0 jika tidak diisi
        $validated['gaji_tunjangan'] = $validated['gaji_tunjangan'] ?? 0;

        // Simpan data staff
        $staff = Staff::create([
            'NIP' => $validated['NIP'],
            'nama' => $validated['nama'],
            'JK' => $validated['JK'],
            'TTL' => $validated['TTL'],
            'notel' => $validated['notel'],
            'alamat' => $validated['alamat'],
            'tgl_masuk' => $validated['tgl_masuk'],
            'tgl_keluar' => $validated['tgl_keluar'],
            'gaji_pokok' => $validated['gaji_pokok'],
            'gaji_tunjangan' => $validated['gaji_tunjangan'],
            'absen_id' => $validated['absen_id'],   
            'is_active' => $validated['is_active'],
        ]);

        // Tambah relasi cabang aktif
        $staff->cabang()->attach($validated['cabang_id'], [
            'is_active' => true,
            'tanggal_mulai' => $validated['tgl_masuk'],
            'tanggal_selesai' => null,
        ]);

        // Tambah relasi jabatan aktif
        $staff->jabatan()->attach($validated['jabatan_id'], [
            'is_active' => true,
            'tanggal_mulai' => $validated['tgl_masuk'],
            'tanggal_selesai' => null,
        ]);

        return redirect()->route('staff.view')->with('success', 'Staff berhasil ditambahkan.');
    }
    public function editView($id)
    {
        $staff = Staff::with(['cabang' => function ($q) {
            $q->wherePivot('is_active', true);
        }, 'jabatan' => function ($q) {
            $q->wherePivot('is_active', true);
        }])->findOrFail($id);

        $cabang = Cabang::where('is_active', 1)->get();
        $jabatan = Jabatan::where('is_active', 1)->get();

        // Ambil ID cabang & jabatan aktif saat ini (jika ada)
        $cabangAktif = $staff->cabang->first();
        $jabatanAktif = $staff->jabatan->first();

        return view('staff.edit', compact('staff', 'cabang', 'jabatan', 'cabangAktif', 'jabatanAktif'));
    }
    public function edit(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);
        $validated = $request->validate([
            'NIP'             => 'required|unique:staff,NIP,' . $staff->id,
            'nama'            => 'required',
            'JK'              => 'required|in:L,P',
            'TTL'             => 'required|date',
            'notel'           => 'required',
            'alamat'          => 'required',
            'tgl_masuk'       => 'required|date',
            'tgl_keluar'      => 'nullable|date|after_or_equal:tgl_masuk',
            'gaji_pokok'      => 'required|numeric',
            'gaji_tunjangan'  => 'required|numeric',
            'is_active'       => 'required|boolean',
            'cabang_id_new'       => 'nullable|exists:cabang,id',
            'cabang_tgl_selesai'  => 'nullable|date',
            'cabang_tgl_mulai'    => 'nullable|date',
            'cabang_tgl_selesai_new' => 'nullable|date|after_or_equal:cabang_tgl_mulai',
            'jabatan_id_new'       => 'nullable|exists:jabatan,id',
            'jabatan_tgl_selesai'  => 'nullable|date',
            'jabatan_tgl_mulai'    => 'nullable|date',
            'jabatan_tgl_selesai_new' => 'nullable|date|after_or_equal:jabatan_tgl_mulai',
        ]);

        // Otomatis nonaktif jika tgl keluar hari ini atau sebelumnya
        if (!empty($validated['tgl_keluar']) && \Carbon\Carbon::parse($validated['tgl_keluar'])->lte(now())) {
            $validated['is_active'] = false;
        }

        // Update data utama
        $staff->update($validated);

        // ==== Cabang ====
        if (!empty($validated['cabang_id_new'])) {
            $currentCabang = $staff->cabang()->wherePivot('is_active', true)->first();
            if (!$currentCabang || $currentCabang->id != $validated['cabang_id_new']) {
                // nonaktifkan cabang lama
                if ($currentCabang) {
                    $staff->cabang()->updateExistingPivot($currentCabang->id, [
                        'is_active' => false,
                        'tanggal_selesai' => $validated['cabang_tgl_selesai'],
                    ]);
                }
                // tambahkan cabang baru
                $staff->cabang()->attach($validated['cabang_id_new'], [
                    'is_active' => true,
                    'tanggal_mulai' => $validated['cabang_tgl_mulai'] ?? now()->toDateString(),
                    'tanggal_selesai' => $validated['cabang_tgl_selesai_new'] ?? null,
                ]);
            }
        }

        // ==== Jabatan ====
        if (!empty($validated['jabatan_id_new'])) {
            $currentJabatan = $staff->jabatan()->wherePivot('is_active', true)->first();
            if (!$currentJabatan || $currentJabatan->id != $validated['jabatan_id_new']) {
                // nonaktifkan jabatan lama
                if ($currentJabatan) {
                    $staff->jabatan()->updateExistingPivot($currentJabatan->id, [
                        'is_active' => false,
                        'tanggal_selesai' => $validated['jabatan_tgl_selesai'],
                    ]);
                }
                // tambahkan jabatan baru
                $staff->jabatan()->attach($validated['jabatan_id_new'], [
                    'is_active' => true,
                    'tanggal_mulai' => $validated['jabatan_tgl_mulai'] ?? now()->toDateString(),
                    'tanggal_selesai' => $validated['jabatan_tgl_selesai_new'] ?? null,
                ]);
            }
        }

        // ==== Jika staff dinonaktifkan, nonaktifkan semua cabang dan jabatan aktif ====
        if ($validated['is_active'] == false) {
            $staff->cabang()->updateExistingPivot(
                $staff->cabang()->pluck('cabang.id')->toArray(),
                ['is_active' => false, 'tanggal_selesai' => now()->toDateString()]
            );
            $staff->jabatan()->updateExistingPivot(
                $staff->jabatan()->pluck('jabatan.id')->toArray(),
                ['is_active' => false, 'tanggal_selesai' => now()->toDateString()]
            );
            if ($staff->users_id) {
                $user = User::find($staff->users_id);

                // Kosongkan dulu users_id di staff
                $staff->update(['users_id' => null]);

                // Baru hapus user-nya
                if ($user) {
                    $user->delete(); // atau forceDelete()
                }
            }
        }

        return redirect()->route('staff.view')->with('success', 'Data staff berhasil diperbarui.');
    }
    public function userForm($id)
    {
        $staff = Staff::findOrFail($id);
        $user = $staff->users_id ? User::find($staff->users_id) : null;

        return view('staff.user_form', compact('staff', 'user'));
    }
    public function saveUser(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);


        $rules = [
            'email' => ['required', 'email', Rule::unique('users')->ignore($staff->users_id)],
            'role' => ['required', 'in:admin,karyawan,kepala'],
        ];

        // Password hanya divalidasi kalau diisi
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }
        $request->validate($rules);
        if ($staff->users_id) {
            $user = User::findOrFail($staff->users_id);
            $user->update([
                'email' => $request->email,
                'role' => $request->role,
                'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            ]);
        } else {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'is_active' => true,
            ]);
            $staff->update(['users_id' => $user->id]);
        }

        return redirect()->route('staff.view')->with('success', 'Akun berhasil disimpan.');
    }
}
