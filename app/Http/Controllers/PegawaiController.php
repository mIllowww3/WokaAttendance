<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use App\Models\Departemen;
use App\Models\Perusahaan;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        return view('admin.pegawai.index', compact('pegawai', 'cari'));
    }

    // CREATE
    public function create()
    {
        $users = User::orderBy('name')->get();
        $departemen = Departemen::orderBy('nama_departemen')->get();
        $kantor = Perusahaan::orderBy('nama_kantor')->get();
        $status = ['aktif', 'nonaktif'];

        return view('admin.pegawai.create', compact('users', 'departemen', 'kantor', 'status'));
    }

    // STORE DATA PEGAWAI + USER LOGIN + QR
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'departemen_id' => 'required',
            'kantor_id' => 'required',
            'no_hp' => 'required|string',
            'alamat' => 'required|string',
            'status' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Simpan foto staff
        $gambar = null;
        if ($request->hasFile('foto')) {
            $gambar = $request->file('foto')->store('staff', 'public');
        }

        // Buat user login
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff',
        ]);

        // Generate UID untuk QR
        $uid = Str::uuid();

        // File name QR
        $qrFileName = $uid . '.png';

        $qrCode = new QrCode($uid);
        $writer = new PngWriter();

        // Hasil binary PNG
        $qrImage = $writer->write($qrCode)->getString();

        // Simpan QR ke storage
        Storage::disk('public')->put('qrcodes/' . $qrFileName, $qrImage);

        // Simpan data pegawai
        Pegawai::create([
            'user_id' => $user->id,
            'departemen_id' => $request->departemen_id,
            'kantor_id' => $request->kantor_id,
            'uid_qr' => $uid,
            'qr_image' => 'qrcodes/' . $qrFileName,
            'qr_generated_at' => now(),
            'foto' => $gambar,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('admin.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan');
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
        $user = $pegawai->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'departemen_id' => 'required|exists:departemens,id',
            'kantor_id' => 'required|exists:perusahaans,id',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'status' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Update tabel users
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
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
            'departemen_id' => $request->departemen_id,
            'kantor_id' => $request->kantor_id,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui');
    }

    // DELETE (Hapus foto, QR, user login dan data pegawai)
    public function delete($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // HAPUS FOTO PEGAWAI
        if ($pegawai->foto && file_exists('uploads/pegawai/' . $pegawai->foto)) {
            unlink('uploads/pegawai/' . $pegawai->foto);
        }

        // HAPUS QR CODE
        if ($pegawai->qr_image && Storage::disk('public')->exists($pegawai->qr_image)) {
            Storage::disk('public')->delete($pegawai->qr_image);
        }

        // HAPUS USER LOGIN
        if ($pegawai->user) {
            $pegawai->user->delete();
        }

        // HAPUS DATA PEGAWAI
        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai dan QR berhasil dihapus.');
    }

    // PROFILE
    public function profile()
    {
        $user = Auth::user();
        $pegawai = Pegawai::with(['departemen', 'kantor'])->where('user_id', $user->id)->first();

        return view('staff.profile.index', compact('pegawai'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = $pegawai->user;

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'no_hp' => 'nullable|string|max:20',
            'departement_id' => 'nullable|exists:departements,id',
            'perusahaan_id' => 'nullable|exists:perusahaans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update password jika ada
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Data Pegawai
        $dataPegawai = [
            'no_hp'          => $request->no_hp,
            'departement_id' => $request->departement_id,
            'perusahaan_id'  => $request->perusahaan_id,
        ];

        // Update FOTO
        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $dataPegawai['foto'] = $request->file('foto')->store('pegawai_foto', 'public');
        }

        $pegawai->update($dataPegawai);

        return redirect()->route('staff.profile.index')
            ->with('success', 'Profil pegawai berhasil diperbarui!');
    }
}
