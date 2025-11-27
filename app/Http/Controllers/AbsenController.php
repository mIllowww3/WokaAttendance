<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    // ============================ ADMIN ============================
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
        return view('admin.absen.show', compact('absen'));
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

    // ============================ STAFF ============================

    // Halaman staff melihat riwayat absen
    public function staffIndex()
    {
        $pegawai = Pegawai::where('user_id', Auth::id())->first();

        $absens = Absen::where('pegawai_id', $pegawai->id)
                        ->orderBy('tanggal', 'desc')
                        ->get();

        return view('staff.absen.index', compact('absens'));
    }
    public function staffStore(Request $request)
{
    $request->validate([
        'qr' => 'required|string'
    ]);

    // Cari pegawai berdasarkan uid_qr
    $pegawai = Pegawai::where('uid_qr', $request->qr)->first();

    if (!$pegawai) {
        return back()->with('error', 'QR Code tidak valid!');
    }

    // Cek apakah sudah absen hari ini
    $absen = Absen::where('pegawai_id', $pegawai->id)
        ->whereDate('tanggal', now()->toDateString())
        ->first();

    // Jika belum, buat absen masuk
    if (!$absen) {
        Absen::create([
            'pegawai_id' => $pegawai->id,
            'tanggal'    => now()->format('Y-m-d'),
            'jam_masuk'  => now()->format('H:i:s'),
            'status'     => 'Hadir',
        ]);

        return back()->with('success', 'Absen masuk berhasil!');
    }

    // Jika sudah absen masuk, update jam pulang
    if ($absen && !$absen->jam_pulang) {
        $absen->update([
            'jam_pulang' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen pulang berhasil!');
    }

    return back()->with('info', 'Anda sudah absen masuk & pulang hari ini.');
}

    // Halaman scan QR (kamera)
    public function scanForm()
    {
        return view('staff.absen.scan');
    }

    // Proses hasil scan QR
    public function scanProcess(Request $request)
    {
        $request->validate([
            'uid_qr' => 'required'
        ]);

        // Cari pegawai berdasarkan UID QR
        $pegawai = Pegawai::where('uid_qr', $request->uid_qr)->first();

        if (!$pegawai) {
            return back()->with('error', 'QR Code tidak valid!');
        }

        // Hari ini
        $today = date('Y-m-d');

        // Cek apakah sudah absen hari ini
        $absen = Absen::where('pegawai_id', $pegawai->id)
                      ->where('tanggal', $today)
                      ->first();

        if (!$absen) {
            // Belum absen → catat jam masuk
            Absen::create([
                'pegawai_id' => $pegawai->id,
                'tanggal'    => $today,
                'jam_masuk'  => now()->format('H:i:s'),
                'status'     => 'Hadir'
            ]);

            return redirect()->back()->with('success', 'Absen masuk berhasil!');
        }

        // Jika sudah absen → catat jam pulang
        if ($absen->jam_pulang == null) {
            $absen->update([
                'jam_pulang' => now()->format('H:i:s')
            ]);

            return redirect()->back()->with('success', 'Absen pulang berhasil!');
        }

        return back()->with('error', 'Anda sudah absen masuk & pulang hari ini.');
    }
}
