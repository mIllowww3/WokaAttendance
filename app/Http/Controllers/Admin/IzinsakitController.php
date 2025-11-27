<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IzinSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinsakitController extends Controller
{
    public function index()
    {
        $data = IzinSakit::with(['pegawai.user','approver'])->latest()->get();
        return view('admin.izin.index', compact('data'));
    }

    public function create()
    {
        abort(404, 'Admin tidak membuat izin.');
    }

    public function store(Request $request)
    {
        abort(404, 'Admin tidak membuat izin.');
    }

    public function show(string $id)
    {
        $izin = IzinSakit::with(['pegawai.user'])->findOrFail($id);
        return view('admin.izin.show', compact('izin'));
    }

    public function edit(string $id)
    {
        abort(404, 'Admin tidak mengedit izin.');
    }

    public function update(Request $request, string $id)
    {
        abort(404, 'Admin tidak mengedit izin.');
    }

    public function destroy(string $id)
    {
        $izin = IzinSakit::findOrFail($id);
        $izin->delete();

        return back()->with('success', 'Data izin berhasil dihapus.');
    }

    public function approve($id)
    {
        $izin = IzinSakit::findOrFail($id);

        $izin->update([
            'status' => 'disetujui',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Izin berhasil disetujui.');
    }

    public function reject($id)
    {
        $izin = IzinSakit::findOrFail($id);

        $izin->update([
            'status' => 'ditolak',
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Izin berhasil ditolak.');
    }
        /* ============================================================
       STAFF: MENAMPILKAN RIWAYAT IZIN
    ============================================================ */
    public function staffIndex()
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;

        $data = IzinSakit::where('pegawai_id', $pegawai->id)
            ->latest()
            ->get();

        return view('staff.izin.index', compact('data'));
    }

    /* ============================================================
       STAFF: FORM PENGAJUAN IZIN
    ============================================================ */
    public function staffCreate()
    {
        return view('staff.izin.create');
    }

    /* ============================================================
       STAFF: SIMPAN PENGAJUAN IZIN
    ============================================================ */
    public function staffStore(Request $request)
    {
        $user = Auth::user();
        $pegawai = $user->pegawai;

        $request->validate([
            'jenis' => 'required|in:izin,sakit',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|max:255',
            'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = [
            'pegawai_id' => $pegawai->id,
            'jenis' => $request->jenis,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ];

        if ($request->hasFile('lampiran')) {
            $data['lampiran'] = $request->file('lampiran')
                ->store('lampiran_izin', 'public');
        }

        IzinSakit::create($data);

        return redirect()->route('staff.izin.index')
            ->with('success', 'Pengajuan izin berhasil dikirim dan menunggu persetujuan.');
    }

}

