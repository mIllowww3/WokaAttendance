<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
   public function index(Request $request)
{
    // Ambil kata kunci pencarian
    $cari = $request->cari;

    // Query dengan pencarian
    $departemen = Departemen::when($cari, function($query) use ($cari) {
            $query->where('nama_departemen', 'LIKE', '%' . $cari . '%');
        })
        ->latest()
        ->get();

    return view('admin.departemen.index', compact('departemen'));
}

public function create()
{
    return view('admin.departemen.create');
}

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        Departemen::create([
            'nama_departemen' => $request->nama_departemen,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.departemen.index')->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $departemen = Departemen::findOrFail($id);
        return view('admin.departemen.edit', compact('departemen'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_departemen' => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        $departemen = Departemen::findOrFail($id);
        $departemen->update([
            'nama_departemen' => $request->nama_departemen,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('departemen.index')->with('success', 'Departemen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();

        return redirect()->route('admin.departemen.index')->with('success', 'Departemen berhasil dihapus!');
    }
}
