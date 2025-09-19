<?php

namespace App\Http\Controllers;

use App\Models\Hutang;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HutangController extends Controller
{
    public function index()
    {
        $data = Hutang::with('staff')->latest()->get();
        return view('hutang.index', compact('data'));
    }

    public function create()
    {
        $staff = Staff::where('is_active', true)->get();
        return view('hutang.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'jumlah_hutang' => 'required|numeric|min:1000',
            'periode_pelunasan' => 'required|integer|min:1',
            'start_pelunasan' => 'required|date',
        ]);

        Hutang::create([
            'staff_id' => $request->staff_id,
            'jumlah_hutang' => $request->jumlah_hutang,
            'periode_pelunasan' => $request->periode_pelunasan,
            'start_pelunasan' => $request->start_pelunasan,
            'sisa_hutang' => $request->jumlah_hutang,
            'keterangan' => $request->keterangan,
            'admin_id' => Auth::user()->staff->id,
        ]);

        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $hutang = Hutang::findOrFail($id);
        $staff = Staff::where('is_active', true)->get();
        return view('hutang.edit', compact('hutang', 'staff'));
    }

    public function update(Request $request, $id)
    {
        $hutang = Hutang::findOrFail($id);

        $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'jumlah_hutang' => 'required|numeric|min:1000',
            'periode_pelunasan' => 'required|integer|min:1',
            'start_pelunasan' => 'required|date',
        ]);

        $hutang->update([
            'staff_id' => $request->staff_id,
            'jumlah_hutang' => $request->jumlah_hutang,
            'periode_pelunasan' => $request->periode_pelunasan,
            'start_pelunasan' => $request->start_pelunasan,
            'sisa_hutang' => $request->jumlah_hutang,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hutang = Hutang::findOrFail($id);
        $hutang->delete();
        return redirect()->route('hutang.index')->with('success', 'Data hutang berhasil dihapus.');
    }
}
