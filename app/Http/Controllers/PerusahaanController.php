<?php

namespace App\Http\Controllers;

use App\Models\Perusahaan;
use Illuminate\Http\Request;

class PerusahaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perusahaan = Perusahaan::all();
        return view('perusahaan.index', compact('perusahaan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('perusahaan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'radius'      => 'required|numeric',
            'alamat'      => 'required|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        Perusahaan::create($request->all());

        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan.show', compact('perusahaan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        return view('perusahaan.edit', compact('perusahaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kantor' => 'required|string|max:255',
            'latitude'    => 'required|numeric',
            'longitude'   => 'required|numeric',
            'radius'      => 'required|numeric',
            'alamat'      => 'required|string',
            'status'      => 'required|in:aktif,nonaktif',
        ]);

        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->update($request->all());

        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $perusahaan = Perusahaan::findOrFail($id);
        $perusahaan->delete();

        return redirect()->route('perusahaan.index')->with('success', 'Data perusahaan berhasil dihapus!');
    }
}
