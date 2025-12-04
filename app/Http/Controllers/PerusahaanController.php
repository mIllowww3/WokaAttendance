<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    public function index()
    {
        $perusahaan = Perusahaan::latest()->get();
        return view('admin.perusahaan.index', compact('perusahaan'));
    }

    public function create()
    {
        return view('admin.perusahaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|unique:perusahaans,nama_kantor',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            'no_hp' => 'nullable|string',
            'alamat' => 'required',
            'status' => 'required'
        ]);

        Perusahaan::create($request->all());

        return redirect()->route('admin.perusahaan.index')->with('success','Data perusahaan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('admin.perusahaan.edit', compact('perusahaan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kantor' => 'required|unique:perusahaans,nama_kantor,' . $id,
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
            'no_hp' => 'nullable',
            'alamat' => 'required',
            'status' => 'required',
        ]);

        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->all());

        return redirect()->route('admin.perusahaan.index')->with('success','Data perusahaan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();
        return back()->with('success', 'Data perusahaan berhasil dihapus');
    }
}
