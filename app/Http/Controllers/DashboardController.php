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
        // Total data
        // $totalPegawai = Pegawai::count();
        // $totalDepartemen = Departemen::count();
        // $totalPerusahaan = Perusahaan::count();
        // $totalAbsen = Absen::count();
        // $totalIzin = Izinsakit::count();

        // $jadwal = Jadwal_kerja::orderBy('id')->get();

        $today = today()->toDateString();
        // Dashboard Hari Ini
        $hadir = Absen::whereDate('tanggal', $today)
            ->whereIn('status', ['hadir', 'telat'])
            ->count();

        $terlambat = Absen::whereDate('tanggal', $today)
            ->where('status', 'telat') // ← sesuai DB kamu
            ->count();

        // ===========================
        // IZIN + SAKIT (disetujui)
        // ===========================
        $izinSakit = IzinSakit::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->count();

        // Alpha (dari tabel absens)
        $alpha = Absen::whereDate('tanggal', $today)
            ->where('status', 'alpha')
            ->count();

        // Gabungan
        $izinSakitAlpha = $izinSakit + $alpha;

        $scan = Absen::whereDate('tanggal', today())->count();

        return view("admin.dashboard", compact(
            "hadir",
            "terlambat",
            "izinSakitAlpha",
            "scan"
        ));
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
