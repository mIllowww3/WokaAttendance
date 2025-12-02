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

        // Simpan foto
        $gambar = null;
        if ($request->hasFile('foto')) {
            $gambar = $request->file('foto')->store('foto_user', 'public');
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
        $qrFileName = $uid . '.png';

        $qrCode = new QrCode($uid);
        $writer = new PngWriter();

        // Simpan QR code
        Storage::disk('public')->put('qrcodes/' . $qrFileName, $writer->write($qrCode)->getString());

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

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai berhasil ditambahkan!');
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

        // Update User
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // UPDATE FOTO
        if ($request->hasFile('foto')) {
            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $path = $request->file('foto')->store('foto_user', 'public');
            $pegawai->foto = $path;
        }

        // Update Data Pegawai
        $pegawai->update([
            'departemen_id' => $request->departemen_id,
            'kantor_id' => $request->kantor_id,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status' => $request->status,
            'foto' => $pegawai->foto
        ]);

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui!');
    }


    public function detail($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        // Jika QR tersimpan di database
        $qrPath = $pegawai->qr_code ?? null;

        return view('admin.pegawai.detail', compact('pegawai', 'qrPath'));
    }


    // DELETE
    public function delete($id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = $pegawai->user;

        if ($pegawai->absens()->exists()) {
            $pegawai->absens()->delete();
        }

        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        if ($pegawai->qr_image && Storage::disk('public')->exists($pegawai->qr_image)) {
            Storage::disk('public')->delete($pegawai->qr_image);
        }

        $pegawai->delete();

        if ($user) {
            $user->delete();
        }

        return redirect()->route('admin.pegawai.index')
            ->with('success', 'Pegawai, absensi, dan akun user berhasil dihapus.');
    }

    // PROFILE USER (STAFF)
    public function profile()
    {
        $user = Auth::user();
        $pegawai = Pegawai::with(['departemen', 'kantor'])->where('user_id', $user->id)->first();

        return view('staff.profile.index', compact('pegawai'));
    }

    // PROFILE UPDATE STAFF (SUDAH DIPERBAIKI)
    public function profileUpdate(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $user = $pegawai->user;

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'no_hp' => 'nullable|string|max:20',
            'departemen_id' => 'nullable|exists:departemens,id',
            'kantor_id' => 'nullable|exists:perusahaans,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // UPDATE PASSWORD
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // UPDATE USER
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // DATA PEGAWAI
        $dataPegawai = [
            'no_hp' => $request->no_hp,
        ];

        // update hanya saat user memilih departemen / kantor
        if ($request->filled('departemen_id')) {
            $dataPegawai['departemen_id'] = $request->departemen_id;
        }

        if ($request->filled('kantor_id')) {
            $dataPegawai['kantor_id'] = $request->kantor_id;
        }

        // UPDATE FOTO
        if ($request->hasFile('foto')) {

            if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
                Storage::disk('public')->delete($pegawai->foto);
            }

            $dataPegawai['foto'] = $request->file('foto')->store('foto_user', 'public');
        }

        $pegawai->update($dataPegawai);

        return redirect()->route('staff.profile.index')
            ->with('success', 'Profil pegawai berhasil diperbarui!');
    }
}
