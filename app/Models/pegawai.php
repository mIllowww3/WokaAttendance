<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    //
    protected $fillable = [
        'user_id',
        'departemen_id',
        'kantor_id',
        'uid_qr',
        'foto',
        'no_hp',
        'alamat',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function departemen()
    {
        return $this->belongsTo(departemen::class);
    }

    public function kantor()
    {
        return $this->belongsTo(perusahaan::class);
    }

    public function absen()
    {
        return $this->hasMany(absen::class);
    }

    public function izinSakit()
    {
        return $this->hasMany(izin::class);
    }
}
