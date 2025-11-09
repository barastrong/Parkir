<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class KendaraanMasuk extends Model
{
    use HasFactory;
    protected $table = 'kendaraan_masuk';
    protected $fillable = [
        'id_user',
        'id_jeniskendaraan',
        'kode_unik',
        'nama_kendaraan',
        'waktu_masuk',
    ];

    function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class, 'id_jeniskendaraan');
    }
}
