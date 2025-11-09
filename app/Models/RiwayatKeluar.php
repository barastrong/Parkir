<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class RiwayatKeluar extends Model
{
    use HasFactory;
    protected $table = 'riwayat_keluar';
    protected $fillable = [
        'id_user',
        'id_jenisKendaraan',
        'kode_unik',
        'nama_kendaraan',
        'waktu_masuk',
        'waktu_keluar',
        'durasi_hari',
        'biaya',    
    ];
    function jenisKendaraan()
    {
        return $this->belongsTo(JenisKendaraan::class, 'id_jenisKendaraan');
    }
    function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
}
