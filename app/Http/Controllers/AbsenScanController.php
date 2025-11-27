<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Absen;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsenScanController extends Controller
{
    // HALAMAN SCAN QR
    public function scanPage()
    {
        return view('pegawai.scan'); // view kamera
    }

    // PROSES QR SETELAH DISCAN
    public function scanProcess(Request $request)
    {
        $uid = $request->uid_qr;

        // Cari pegawai berdasarkan UID QR
        $pegawai = Pegawai::where('uid_qr', $uid)->first();

        if (!$pegawai) {
            return response()->json([
                'status' => false,
                'message' => 'QR Code tidak valid!'
            ]);
        }

        $tanggal = Carbon::now()->toDateString();

        // Cek apakah pegawai sudah absen hari ini
        $absenHariIni = Absen::where('pegawai_id', $pegawai->id)
            ->where('tanggal', $tanggal)
            ->first();

        if (!$absenHariIni) {
            // ABSEN MASUK
            $absen = Absen::create([
                'pegawai_id' => $pegawai->id,
                'tanggal' => $tanggal,
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'jam_keluar' => null
            ]);

            return response()->json([
                'status' => true,
                'type' => 'masuk',
                'message' => 'Absen MASUK berhasil!',
                'pegawai' => $pegawai->name,
                'jam' => $absen->jam_masuk
            ]);
        } else {

            // Jika sudah absen masuk namun belum absen keluar
            if ($absenHariIni->jam_keluar == null) {
                $absenHariIni->update([
                    'jam_keluar' => Carbon::now()->format('H:i:s')
                ]);

                return response()->json([
                    'status' => true,
                    'type' => 'keluar',
                    'message' => 'Absen KELUAR berhasil!',
                    'pegawai' => $pegawai->name,
                    'jam' => $absenHariIni->jam_keluar
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Anda sudah absen MASUK dan KELUAR hari ini.'
                ]);
            }
        }
    }
}
