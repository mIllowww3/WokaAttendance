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

        $izinSakitYesterday = IzinSakit::where('status', 'disetujui')
            ->whereDate('tanggal_mulai', $yesterday)
            ->count();

        $alphaYesterday = Absen::whereDate('tanggal', $yesterday)
            ->where('status', 'alpha')
            ->count();

        $izinSakitAlphaYesterday = $izinSakitYesterday + $alphaYesterday;

        $scanYesterday = Absen::whereDate('tanggal', $yesterday)->count();


        // =====================================================
        // FUNGSI HITUNG PERSEN
        // =====================================================
        $persen = function ($today, $yesterday) {
            if ($yesterday == 0) return 0;
            return round(($today / $yesterday) * 100, 1);
        };

        // Hitung persen
        $hadirPersen = $persen($hadir, $hadirYesterday);
        $terlambatPersen = $persen($terlambat, $terlambatYesterday);
        $izinSakitAlphaPersen = $persen($izinSakitAlpha, $izinSakitAlphaYesterday);
        $scanPersen = $persen($scan, $scanYesterday);


        // =====================================================
        // REKAP PER DEPARTEMEN
        // =====================================================
        $rekapDepartemen = Departemen::withCount([
            'pegawai as hadir' => function ($q) use ($today) {
                $q->whereHas('absens', function ($absen) use ($today) {
                    $absen->whereDate('tanggal', $today)
                        ->whereIn('status', ['hadir', 'telat']);
                });
            },

            'pegawai as terlambat' => function ($q) use ($today) {
                $q->whereHas('absens', function ($absen) use ($today) {
                    $absen->whereDate('tanggal', $today)
                        ->where('status', 'telat');
                });
            },

            'pegawai as izinAlpha' => function ($q) use ($today) {
                $q->where(function ($sub) use ($today) {
                    $sub->whereHas('izins', function ($izin) use ($today) {
                        $izin->where('status', 'disetujui')
                            ->whereDate('tanggal_mulai', '<=', $today)
                            ->whereDate('tanggal_selesai', '>=', $today);
                    })
                        ->orWhereHas('absens', function ($absen) use ($today) {
                            $absen->whereDate('tanggal', $today)
                                ->where('status', 'alpha');
                        });
                });
            },

        ])->get();


        // =====================================================
        // REKAP KEHADIRAN BULAN INI
        // =====================================================
        $bulan = today()->month;
        $tahun = today()->year;

        // Total hari kerja (1 bulan penuh) – jika ingin exclude sabtu/minggu bilang saja
        $totalHari = now()->daysInMonth;

        // Total pegawai
        $totalPegawai = Pegawai::count();

        // Total kesempatan hadir (pegawai × hari)
        $totalKesempatan = $totalPegawai * $totalHari;


        // --- Hitung jumlah hadir bulan ini ---
        $hadirBulanan = Absen::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereIn('status', ['hadir', 'telat'])
            ->count();

        // --- Hitung terlambat bulan ini ---
        $telatBulanan = Absen::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'telat')
            ->count();

        // --- Hitung tidak hadir (alpha + izin/sakit) ---
        $alphaBulanan = Absen::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'alpha')
            ->count();

        $izinSakitBulanan = IzinSakit::where('status', 'disetujui')
            ->whereMonth('tanggal_mulai', $bulan)
            ->whereYear('tanggal_mulai', $tahun)
            ->count();

        $tidakHadirBulanan = $alphaBulanan + $izinSakitBulanan;


        // --- Hitung Persentase ---
        $persenHadirBulanan = $totalKesempatan > 0
            ? round(($hadirBulanan / $totalKesempatan) * 100)
            : 0;

        $persenTelatBulanan = $totalKesempatan > 0
            ? round(($telatBulanan / $totalKesempatan) * 100)
            : 0;

        $persenTidakHadirBulanan = $totalKesempatan > 0
            ? round(($tidakHadirBulanan / $totalKesempatan) * 100)
            : 0;

        // =====================================================
        // 🔥 TOP 5 RAJIN & TERLAMBAT DARI DATABASE
        // =====================================================
        $topRajin = Pegawai::with('user')
            ->withCount([
                'absens as total_telat' => function ($q) {
                    $q->where('status', 'telat');
                }
            ])
            ->orderBy('total_telat', 'asc')
            ->limit(5)
            ->get();

        $topTerlambat = Pegawai::with('user')
            ->withCount([
                'absens as total_telat' => function ($q) {
                    $q->where('status', 'telat');
                }
            ])
            ->orderBy('total_telat', 'desc')
            ->limit(5)
            ->get();

        // =====================================================
        // 📊 GRAFIK 7 HARI
        // =====================================================
        $dates = collect();
        for ($i = 6; $i >= 0; $i--) {
            $dates->push(today()->subDays($i)->format('Y-m-d'));
        }

        $hadirMingguan = $dates->map(function ($date) {
            return Absen::whereDate('tanggal', $date)
                ->whereIn('status', ['hadir', 'telat'])
                ->count();
        });

        // =====================================================
        // KIRIM DATA KE VIEW
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
            "topTerlambat",
            "dates",
            "hadirMingguan",
            "persenHadirBulanan",
            "persenTelatBulanan",
            "persenTidakHadirBulanan",
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
