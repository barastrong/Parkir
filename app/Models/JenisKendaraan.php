<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JenisKendaraan extends Model
{
    use HasFactory;

    protected $table = 'jenis_kendaraan';
    protected $fillable = [
        'jenis_kendaraan',
        'harga',
        'kapasitas_slot',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'kapasitas_slot' => 'integer',
        ];
    }

    // Relasi dengan KendaraanMasuk
    public function kendaraanMasuk()
    {
        return $this->hasMany(KendaraanMasuk::class, 'id_jeniskendaraan');
    }
}