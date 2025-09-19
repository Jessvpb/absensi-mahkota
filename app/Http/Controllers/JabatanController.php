<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;

class JabatanController extends Controller
{
    public function view(Request $request)
    {
        $filter = $request->query('filter', 'aktif');
        $dataJabatan = Jabatan::query();
        $dataSemuaJabatan = Jabatan::all();
        if ($filter === 'aktif') {
            $dataJabatan->where('is_active', 1);
        } elseif ($filter === 'nonaktif') {
            $dataJabatan->where('is_active', 0);
        }
        $dataJabatan = $dataJabatan->get();
        return view('jabatan.index', compact('dataJabatan','dataSemuaJabatan', 'filter'));
    }
    public function addView()
    {
        return view('jabatan.add');
    }
    public function add(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string',
            'is_active' => 'required|in:0,1',
        ]);

        Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('jabatan.view')->with('success', 'Data jabatan berhasil disimpan!');
    }
    public function editView($id)
    {
        $jabatan = Jabatan::find($id);
        return view("jabatan.edit",compact('jabatan'));
    }
    public function edit(Request $request, $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        $validated = $request->validate([
            'nama_jabatan' => 'required|string',
            'is_active' => 'required|in:0,1',
        ]);
        $jabatan->update($validated);

        return redirect()->route('jabatan.view')->with('success', 'Data jabatan berhasil diupdate');
    }
}
