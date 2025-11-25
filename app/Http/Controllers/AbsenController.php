<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class AbsenController extends Controller
{
    public function absen()
    {
        $absens = Absen::with(['pegawai'])->orderBy('tanggal','desc')->get();
        return view('admin.absen.index', compact('absens'));
    }
    public function index()
    {
        $absens = Absen::with('pegawai')->orderBy('tanggal', 'desc')->get();
        return view('absen.index', compact('absens'));
    }

    public function create()
    {
        $pegawai = Pegawai::all();
        return view('absen.create', compact('pegawai'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id'    => 'required|exists:pegawais,id',
            'tanggal'       => 'required|date',
            'jam_masuk'     => 'nullable',
            'jam_pulang'    => 'nullable',
            'status'        => 'required|string',
            'lokasi_masuk'  => 'nullable|string',
            'lokasi_pulang' => 'nullable|string',
            'jarak_masuk'   => 'nullable|numeric',
            'jarak_pulang'  => 'nullable|numeric',
            'catatan'       => 'nullable|string',
        ]);

        Absen::create($request->all());

        return redirect()->route('absen.index')->with('success', 'Data absen berhasil ditambahkan!');
    }

    public function show($id)
    {
        $absen = Absen::with('pegawai')->findOrFail($id);
        return view('absen.show', compact('absen'));
    }

    public function edit($id)
    {
        $absen = Absen::findOrFail($id);
        $pegawai = Pegawai::all();
        return view('absen.edit', compact('absen', 'pegawai'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pegawai_id'    => 'required|exists:pegawais,id',
            'tanggal'       => 'required|date',
            'jam_masuk'     => 'nullable',
            'jam_pulang'    => 'nullable',
            'status'        => 'required|string',
            'lokasi_masuk'  => 'nullable|string',
            'lokasi_pulang' => 'nullable|string',
            'jarak_masuk'   => 'nullable|numeric',
            'jarak_pulang'  => 'nullable|numeric',
            'catatan'       => 'nullable|string',
        ]);

        $absen = Absen::findOrFail($id);
        $absen->update($request->all());

        return redirect()->route('absen.index')->with('success', 'Data absen berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $absen = Absen::findOrFail($id);
        $absen->delete();

        return redirect()->route('absen.index')->with('success', 'Data absen berhasil dihapus!');
    }
}
