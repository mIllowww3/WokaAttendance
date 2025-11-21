<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perusahaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kantor','latitude','longitude','radius','alamat','status'
    ];

    public function pegawai()
    {
        return $this->hasMany(Pegawai::class);
    }
}
