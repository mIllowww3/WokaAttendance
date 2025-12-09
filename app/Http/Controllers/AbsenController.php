<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Jadwal_kerja;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsenController extends Controller
{
    // ============================ ADMIN ============================
    public function absen()
    {
        $absens = Absen::with(['pegawai'])->orderBy('tanggal', 'desc')->orderBy('jam_masuk','desc')->orderBy('jam_pulang','desc')->get();
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
        // Validasi input
        $request->validate([
            'pegawai_id'    => 'required|exists:pegawais,id',
            'status'        => 'required|string', // hadir, izin, sakit, dll
            'jam_masuk'     => 'nullable',
            'jam_pulang'    => 'nullable',
            'lokasi_masuk'  => 'nullable|string',
            'lokasi_pulang' => 'nullable|string',
            'jarak_masuk'   => 'nullable|numeric',
            'jarak_pulang'  => 'nullable|numeric',
            'catatan'       => 'nullable|string',
        ]);

        $pegawaiId = $request->pegawai_id;
        $today = Carbon::today();

        // 🔹 Cek apakah pegawai sudah absen hari ini
        if (Absen::where('pegawai_id', $pegawaiId)
            ->where('tanggal', $today)
            ->exists()
        ) {
            return back()->with('error', 'Pegawai sudah absen hari ini');
        }

        // 🔹 Ambil absen terakhir pegawai
        $lastAbsen = Absen::where('pegawai_id', $pegawaiId)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_masuk', 'desc')
            ->first();

        // Jika ada absen sebelumnya → cek hari yang terlewat
        if ($lastAbsen) {
            $nextDate = Carbon::parse($lastAbsen->tanggal)->addDay();

            // Loop sampai hari sebelum hari ini
            while ($nextDate->lt($today)) {

                // Lewati Sabtu & Minggu
                if (!in_array($nextDate->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {

                    // Buat absensi otomatis ALPA
                    Absen::create([
                        'pegawai_id'  => $pegawaiId,
                        'tanggal'     => $nextDate->toDateString(),
                        'status'      => 'alpha',
                        'jam_masuk'   => null,
                        'jam_pulang'  => null,
                        'catatan'     => 'Tidak Melakukan Absensi',
                    ]);
                }

                // ke tanggal berikutnya
                $nextDate->addDay();
            }
        }

        // 🔹 Simpan absensi hari ini
        Absen::create([
            'pegawai_id'    => $pegawaiId,
            'tanggal'       => $today,
            'jam_masuk'     => $request->jam_masuk,
            'jam_pulang'    => $request->jam_pulang,
            'status'        => $request->status,
            'lokasi_masuk'  => $request->lokasi_masuk,
            'lokasi_pulang' => $request->lokasi_pulang,
            'jarak_masuk'   => $request->jarak_masuk,
            'jarak_pulang'  => $request->jarak_pulang,
            'catatan'       => $request->catatan,
        ]);

        return redirect()->route('absen.index')->with('success', 'Absensi berhasil ditambahkan!');
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
    // STAFF ABSEN via QR
    public function staffStore(Request $request)
{
    $request->validate([
        'qr' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
    ]);

    $qr = trim($request->qr);

    $pegawai = Pegawai::where('user_id', Auth::id())
        ->where('uid_qr', $qr)
        ->first();

    if (!$pegawai) {
        return back()->with('error', 'QR Code tidak sesuai dengan akun Anda!');
    }

    // =======================================
    // Validasi lokasi (Haversine Formula)
    // =======================================

    // Lokasi kantor (ISI DENGAN LAT-LONG KANTOR ANDA)
    $officeLat  = -5.1408167;    // contoh Woka Academy
    $officeLong = 105.3098427;   // contoh Woka Academy

    $userLat  = $request->latitude;
    $userLong = $request->longitude;

    // Rumus haversine
    $earthRadius = 6371000; // meter

    $latDelta = deg2rad($userLat - $officeLat);
    $longDelta = deg2rad($userLong - $officeLong);

    $a = sin($latDelta/2) * sin($latDelta/2) +
        cos(deg2rad($officeLat)) * cos(deg2rad($userLat)) *
        sin($longDelta/2) * sin($longDelta/2);

    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    $distance = $earthRadius * $c;

    $radius = 50; // meter

    if ($distance > $radius) {
        return back()->with('error', 'Anda berada di luar radius lokasi absen! Jarak anda: ' . round($distance) . ' meter');
    }

    // ======================
    // Isi ALPA otomatis
    // ======================
    $today = Carbon::today();

    $lastAbsensi = Absen::where('pegawai_id', $pegawai->id)
        ->orderBy('tanggal', 'desc')
        ->orderBy('jam_masuk', 'desc')
        ->first();

    if ($lastAbsensi) {
        $nextDate = Carbon::parse($lastAbsensi->tanggal)->addDay();

        while ($nextDate->lt($today)) {

            if (!in_array($nextDate->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
                Absen::create([
                    'pegawai_id' => $pegawai->id,
                    'tanggal'    => $nextDate->toDateString(),
                    'status'     => 'alpha',
                    'keterangan' => 'Tidak melakukan absen',
                ]);
            }

            $nextDate->addDay();
        }
    }

    // ======================
    // Ambil jadwal
    // ======================
    $hariIni = now()->format('l');
    $jadwal = Jadwal_kerja::where('hari', $hariIni)->first();

    $jamBatas = $jadwal->jam_masuk ?? "08:00:00";

    $absen = Absen::where('pegawai_id', $pegawai->id)
        ->whereDate('tanggal', now()->toDateString())
        ->first();

    if (!$absen) {
        $jamMasuk = now()->format('H:i:s');
        $status = ($jamMasuk > $jamBatas) ? "telat" : "hadir";

        Absen::create([
            'pegawai_id' => $pegawai->id,
            'tanggal'    => now()->format('Y-m-d'),
            'jam_masuk'  => $jamMasuk,
            'status'     => $status,
        ]);

        return back()->with('success', $status == "telat" ? 'Anda Telat!' : 'Absen masuk berhasil!');
    }

    if (!$absen->jam_pulang) {
        $absen->update([
            'jam_pulang' => now()->format('H:i:s'),
        ]);

        return back()->with('success', 'Absen pulang berhasil!');
    }

    return back()->with('info', 'Anda sudah absen hari ini.');
}


    // Halaman scan QR (kamera)
    public function scanForm()
    {
        return view('staff.absen.scan');
    }

    // Proses hasil scan QR kamera
    public function scanProcess(Request $request)
    {
        $request->validate([
            'uid_qr' => 'required'
        ]);

        // Pegawai yang login
        $loggedPegawai = Pegawai::where('user_id', Auth::id())->first();

        if (!$loggedPegawai) {
            return back()->with('error', 'Akun ini tidak terdaftar sebagai pegawai!');
        }

        // QR tidak boleh milik orang lain
        if ($loggedPegawai->uid_qr !== $request->uid_qr) {
            return back()->with('error', 'QR Code ini bukan milik Anda!');
        }

        $today = date('Y-m-d');

        $absen = Absen::where('pegawai_id', $loggedPegawai->id)
            ->where('tanggal', $today)
            ->first();

        if (!$absen) {
            Absen::create([
                'pegawai_id' => $loggedPegawai->id,
                'tanggal'    => $today,
                'jam_masuk'  => now()->format('H:i:s'),
                'status'     => 'Hadir'
            ]);

            return back()->with('success', 'Absen masuk berhasil!');
        }

        if ($absen->jam_pulang == null) {
            $absen->update([
                'jam_pulang' => now()->format('H:i:s')
            ]);

            return back()->with('success', 'Absen pulang berhasil!');
        }

        return back()->with('error', 'Anda sudah absen masuk & pulang hari ini.');
    }
}
