<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\User;
use App\Models\Departemen;
use App\Models\Izinsakit;
use App\Models\Perusahaan;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        'pegawai_id' => 'required|exists:pegawai,id',
        'jenis' => 'required|in:izin,sakit',
        'tanggal_mulai' => 'required|date',
        'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        'alasan' => 'required|string',
        'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Upload lampiran jika ada
    $lampiran = null;
    if ($request->hasFile('lampiran')) {
        $lampiran = $request->file('lampiran')->store('lampiran_izin', 'public');
    }

    // Simpan izin/sakit
    Izinsakit::create([
        'pegawai_id' => $request->pegawai_id,
        'jenis' => $request->jenis,
        'tanggal_mulai' => $request->tanggal_mulai,
        'tanggal_selesai' => $request->tanggal_selesai,
        'alasan' => $request->alasan,
        'lampiran' => $lampiran,
        'status' => 'pending',
        'approved_by' => null,
    ]);

    return redirect()
        ->route('staff.izin.index')
        ->with('success', 'Pengajuan izin/sakit berhasil diajukan.');
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

        return redirect()->route('admin.pegawai.index')->with('success', 'Data pegawai berhasil diperbarui');
    }

    // DELETE
    public function destroy($id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->foto && file_exists('uploads/pegawai/' . $pegawai->foto)) {
            unlink('uploads/pegawai/' . $pegawai->foto);
        }

        $pegawai->delete();

        return redirect()->route('admin.pegawai.index')->with('success', 'Pegawai berhasil dihapus');
    }
    public function profile()
    {
        $user = FacadesAuth::user();
        $pegawai = Pegawai::with(['departemen', 'kantor'])->where('user_id', $user->id)->first();

        return view('staff.profile.index', compact('pegawai'));
    }

    public function profileUpdate(Request $request, $id)
{
    // Ambil data pegawai berdasarkan id
    $pegawai = Pegawai::findOrFail($id);
    $user = $pegawai->user;

    // Validasi input
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8',

        'no_hp' => 'nullable|string|max:20',
        'departement_id' => 'nullable|exists:departements,id',
        'perusahaan_id' => 'nullable|exists:perusahaans,id',

        'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    /* ==========================
       UPDATE USER (nama, email, password)
    ========================== */
    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->update([
        'name'  => $request->name,
        'email' => $request->email,
        'password' => $user->password,
    ]);

    /* ==========================
       UPDATE PEGAWAI
    ========================== */
    $dataPegawai = [
        'no_hp'          => $request->no_hp,
        'departement_id' => $request->departement_id,
        'perusahaan_id'  => $request->perusahaan_id,
    ];

    /* ==========================
       UPDATE FOTO
    ========================== */
    if ($request->hasFile('foto')) {

        // hapus foto lama
        if ($pegawai->foto && Storage::disk('public')->exists($pegawai->foto)) {
            Storage::disk('public')->delete($pegawai->foto);
        }

        // upload foto baru
        $dataPegawai['foto'] = $request->file('foto')->store('pegawai_foto', 'public');
    }

    // Simpan data pegawai
    $pegawai->update($dataPegawai);

    return redirect()->route('staff.profile.index')
        ->with('success', 'Profil pegawai berhasil diperbarui!');
}

}
