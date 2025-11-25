<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Departemen;
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

        return view("admin.dashboard", compact("totalPegawai","totalDepartemen","totalPerusahaan","totalAbsen"));
    }
}
