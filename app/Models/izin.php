<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'pegawai_id','tanggal_mulai','tanggal_selesai',
        'jenis','alasan','lampiran','status','approved_by'
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
