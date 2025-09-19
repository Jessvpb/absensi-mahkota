<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;

class CabangController extends Controller
{
    public function view(Request $request)
    {
        $filter = $request->query('filter', 'aktif');
        $search = $request->query('search'); // Ambil parameter search

        $dataCabang = Cabang::query();
        $dataCabangSemua = Cabang::all  ();

        // Filter status
        if ($filter === 'aktif') {
            $dataCabang->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataCabang->where('is_active', 0);
        }
        // Jika filter 'semua', tidak perlu tambahan kondisi where

        // Filter pencarian berdasarkan nama cabang
        if ($search) {
            $dataCabang->where('nama_cabang', 'like', '%' . $search . '%');
        }

        $dataCabang = $dataCabang->get();
        return view('cabang.index', compact('dataCabang', 'filter', 'search','dataCabangSemua')); // Kirim variabel search ke view
    }
    public function addView()
    {
        return view('cabang.add');
    }
    public function add(Request $request)
    {
        $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i|after:jam_masuk',
            'is_active' => 'required|in:0,1',
        ]);

        Cabang::create([
            'nama_cabang' => $request->nama_cabang,
            'alamat' => $request->alamat,
            'jam_masuk' => $request->jam_masuk,
            'jam_pulang' => $request->jam_pulang,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('cabang.view')->with('success', 'Data cabang berhasil disimpan!');
    }
    public function editView($id)
    {
        $cabang = Cabang::find($id);
        return view("cabang.edit", compact('cabang'));
    }
    public function edit(Request $request, $id)
    {
        $cabang = Cabang::findOrFail($id);

        $validated = $request->validate([
            'nama_cabang' => 'required|string|max:100',
            'alamat' => 'required|string',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i|after:jam_masuk',
            'is_active' => 'required|in:0,1',
        ]);
        // dd($validated);

        $cabang->update($validated);

        return redirect()->route('cabang.view')->with('success', 'Data cabang berhasil diupdate');
    }
}
