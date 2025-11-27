<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Departemen;
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

        $jadwal = Jadwal_kerja::orderBy('id')->get();

        return view("admin.dashboard", compact("totalPegawai","totalDepartemen","totalPerusahaan","totalAbsen","jadwal"));
    }

    public function staff()
{
    $jadwal = Jadwal_kerja::orderBy('id')->get();

    return view('staff.dashboard', compact('jadwal'));
}

}
