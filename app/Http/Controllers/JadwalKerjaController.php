<?php

namespace App\Http\Controllers;

use App\Models\Jadwal_kerja;
use Illuminate\Http\Request;

class JadwalKerjaController extends Controller
{
    public function index(Request $request)
    {
        $cari = $request->cari;

        $jadwal = Jadwal_kerja::when($cari, function($query) use ($cari) {
            $query->where('hari', 'like', "%$cari%");
        })
        ->orderBy('id', 'asc')
        ->paginate(10);

        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
         $request->validate([
        'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu|unique:jadwal_kerjas,hari',
        'jam_masuk'   => 'required',
        'jam_pulang'  => 'required|after:jam_masuk', // ⬅ VALIDASI BARU
    ], [
        'jam_pulang.after' => 'Jam pulang tidak boleh kurang dari jam masuk.',
    ]);

        Jadwal_kerja::create($request->all());

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal kerja berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = Jadwal_kerja::findOrFail($id);
        return view('admin.jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
    $request->validate([
        'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu|unique:jadwal_kerjas,hari,' . $id  ,
        'jam_masuk'   => 'required',
        'jam_pulang'  => 'required|after:jam_masuk', // ⬅ VALIDASI BARU
    ], [
        'jam_pulang.after' => 'Jam pulang tidak boleh kurang dari jam masuk.',
    ]);

        $jadwal = Jadwal_kerja::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal kerja berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Jadwal_kerja::destroy($id);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal kerja berhasil dihapus.');
    }
}
