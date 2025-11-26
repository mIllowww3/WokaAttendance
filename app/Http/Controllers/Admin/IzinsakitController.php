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
}

