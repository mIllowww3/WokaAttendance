<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    protected $fillable = [
        'user_id',
        'departemen_id',
        'kantor_id',
        'uid_qr',
        'qr_image',
        'qr_generated_at',
        'foto',
        'no_hp',
        'alamat',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function kantor()
    {
        return $this->belongsTo(Perusahaan::class);
    }

    // Perbaikan nama relasi
    public function absens()
    {
        return $this->hasMany(Absen::class);
    }

    public function izins()
    {
        return $this->hasMany(Izinsakit::class);
    }
}
