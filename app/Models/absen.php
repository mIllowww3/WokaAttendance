<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absen extends Model
{
    use HasFactory;

    protected $fillable = [
        'pegawai_id','tanggal','jam_masuk','jam_pulang','status',
        'lokasi_masuk','lokasi_pulang','jarak_masuk','jarak_pulang',
        'catatan'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }
}
