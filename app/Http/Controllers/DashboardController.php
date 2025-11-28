<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Departemen;
use App\Models\Izinsakit;
use App\Models\Jadwal_kerja;
use App\Models\Pegawai;
use App\Models\Perusahaan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function admin()
    {
        $totalPegawai = Pegawai::count();
        $totalDepartemen = Departemen::count();
        $totalPerusahaan = Perusahaan::count();
        $totalAbsen = Absen::count();
        $totalIzin = Izinsakit::count();

        $jadwal = Jadwal_kerja::orderBy('id')->get();

        return view("admin.dashboard", compact("totalPegawai", "totalDepartemen", "totalPerusahaan", "totalAbsen", "totalIzin", "jadwal",));
    }

    public function staff()
    {
        // Ambil pegawai yang login
        $pegawai = auth()->user()->pegawai;

        // Jika user belum punya data pegawai
        if (!$pegawai) {
            return back()->with('error', 'Data pegawai tidak ditemukan.');
        }

        // Total absen khusus pegawai yang login
        $totalAbsen = $pegawai->absens()->count();

        // Total izin khusus pegawai yang login
        $totalIzin = $pegawai->izins()->count();

        // Jadwal kerja ambil semua (atau khusus pegawai jika ada relasi)
        $jadwal = Jadwal_kerja::orderBy('id')->get();

        return view('staff.dashboard', compact("totalAbsen", "totalIzin", "jadwal"));
    }
}
