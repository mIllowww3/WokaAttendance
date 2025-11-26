<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use App\Models\Departemen;
use App\Models\Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PegawaiController extends Controller
{
    // INDEX + SEARCH
    public function index(Request $request)
    {
        $cari = $request->cari;

        $pegawai = Pegawai::with(['departemen', 'kantor', 'user'])
            ->when($cari, function ($query) use ($cari) {
                $query->whereHas('user', function ($q) use ($cari) {
                    $q->where('name', 'like', "%$cari%");
                });
            })
            ->paginate(10);

        return view('admin.pegawai.index', compact('pegawai'));
    }


    // CREATE
    public function create()
    {
        $users = User::orderBy('name')->get();
        $departemen = Departemen::orderBy('nama_departemen')->get();
        $kantor = Perusahaan::orderBy('nama_kantor')->get();

        return view('admin.pegawai.create', compact('users', 'departemen', 'kantor'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'departemen_id' => 'required',
            'kantor_id' => 'required',
            'no_hp' => 'nullable|string',
            'status' => 'required',
            'foto' => 'required|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $gambar = $request->file('foto')->store('staff', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        Pegawai::create([
            'user_id' => $user->id,
            'departemen_id' => $request->departemen_id,
            'kantor_id' => $request->kantor_id,
            'uid_qr' => Str::uuid(),
            'foto' => $gambar,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil ditambahkan');
    }

    // EDIT
    public function edit($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $users = User::orderBy('name')->get();
        $departemen = Departemen::orderBy('nama_departemen')->get();
        $kantor = Perusahaan::orderBy('nama_kantor')->get();

        return view('admin.pegawai.edit', compact('pegawai', 'users', 'departemen', 'kantor'));
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'user_id' => 'required',
            'departemen_id' => 'required',
            'kantor_id' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|max:2048'
        ]);

        // FOTO
        if ($request->hasFile('foto')) {
            $fileName = time() . '-' . $request->foto->getClientOriginalName();
            $request->foto->move('uploads/pegawai/', $fileName);

            if ($pegawai->foto && file_exists('uploads/pegawai/' . $pegawai->foto)) {
                unlink('uploads/pegawai/' . $pegawai->foto);
            }

            $pegawai->foto = $fileName;
        }

        $pegawai->update([
            'user_id' => $request->user_id,
            'departemen_id' => $request->departemen_id,
            'kantor_id' => $request->kantor_id,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui');
    }

    // DELETE
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->foto && file_exists('uploads/pegawai/' . $pegawai->foto)) {
            unlink('uploads/pegawai/' . $pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
}
