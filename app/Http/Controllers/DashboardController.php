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
        $today = today()->toDateString();
        $yesterday = today()->subDay()->toDateString();

        // =====================================================
        // DATA HARI INI
        // =====================================================
        $hadir = Absen::whereDate('tanggal', $today)
            ->whereIn('status', ['hadir', 'telat'])
            ->count();

        $terlambat = Absen::whereDate('tanggal', $today)
            ->where('status', 'telat')
            ->count();

        // Izin & Sakit HARI INI SAJA
        $izinSakit = IzinSakit::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', $today)
            ->count();

        // Alpha hari ini
        $alpha = Absen::whereDate('tanggal', $today)
            ->where('status', 'alpha')
            ->count();

        $izinSakitAlpha = $izinSakit + $alpha;

        // Total scan hari ini
        $scan = Absen::whereDate('tanggal', $today)->count();


        // =====================================================
        // DATA KEMARIN (UNTUK HITUNG PERSEN)
        // =====================================================
        $hadirYesterday = Absen::whereDate('tanggal', $yesterday)
            ->whereIn('status', ['hadir', 'telat'])
            ->count();

        $terlambatYesterday = Absen::whereDate('tanggal', $yesterday)
            ->where('status', 'telat')
            ->count();

        // Izin & Sakit KEMARIN SAJA (bukan rentang)
        $izinSakitYesterday = IzinSakit::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', $yesterday)
            ->count();

        // Alpha kemarin
        $alphaYesterday = Absen::whereDate('tanggal', $yesterday)
            ->where('status', 'alpha')
            ->count();

        $izinSakitAlphaYesterday = $izinSakitYesterday + $alphaYesterday;

        // Total scan kemarin
        $scanYesterday = Absen::whereDate('tanggal', $yesterday)->count();


        // =====================================================
        // FUNGSI HITUNG PERSEN (ANTI 100%)
        // =====================================================
        $persen = function ($today, $yesterday) {
            if ($today == 0 && $yesterday == 0) return 0;
            if ($yesterday == 0) return 0; // agar tidak jadi 100%
            return round((($today - $yesterday) / $yesterday) * 100, 1);
        };


        // =====================================================
        // HITUNG PERSEN MASING-MASING CARD
        // =====================================================
        $hadirPersen = $persen($hadir, $hadirYesterday);
        $terlambatPersen = $persen($terlambat, $terlambatYesterday);
        $izinSakitAlphaPersen = $persen($izinSakitAlpha, $izinSakitAlphaYesterday);
        $scanPersen = $persen($scan, $scanYesterday);

        $rekapDepartemen = Departemen::withCount([
            // H A D I R
            'pegawai as hadir' => function ($q) use ($today) {
                $q->whereHas('absens', function ($absen) use ($today) {
                    $absen->whereDate('tanggal', $today)
                        ->whereIn('status', ['hadir', 'telat']);
                });
            },

            // T E R L A M B A T
            'pegawai as terlambat' => function ($q) use ($today) {
                $q->whereHas('absens', function ($absen) use ($today) {
                    $absen->whereDate('tanggal', $today)
                        ->where('status', 'telat');
                });
            },

            // I Z I N + S A K I T + A L P H A
            'pegawai as izinAlpha' => function ($q) use ($today) {
                $q->where(function ($sub) use ($today) {

                    // Izin / sakit di tabel izin_sakit
                    $sub->whereHas('izins', function ($izin) use ($today) {
                        $izin->where('status', 'disetujui')
                            ->whereDate('tanggal_mulai', '<=', $today)
                            ->whereDate('tanggal_selesai', '>=', $today);
                    })

                        // Alpha dari tabel absens
                        ->orWhereHas('absens', function ($absen) use ($today) {
                            $absen->whereDate('tanggal', $today)
                                ->where('status', 'alpha');
                        });
                });
            },

        ])->get();



        $topRajin = Pegawai::withCount([
            'absens as total_telat' => function ($q) {
                $q->where('status', 'telat');
            }
        ])
            ->orderBy('total_telat', 'asc')
            ->limit(5)
            ->get();


        $topTerlambat = Pegawai::withCount([
            'absens as total_telat' => function ($q) {
                $q->where('status', 'telat');
            }
        ])
            ->orderBy('total_telat', 'desc')
            ->limit(5)
            ->get();


        // =====================================================
        // KIRIM KE VIEW
        // =====================================================
        return view("admin.dashboard", compact(
            "hadir",
            "terlambat",
            "izinSakitAlpha",
            "scan",
            "hadirPersen",
            "terlambatPersen",
            "izinSakitAlphaPersen",
            "scanPersen",
            "rekapDepartemen",
            "topRajin",
            "topTerlambat"
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
