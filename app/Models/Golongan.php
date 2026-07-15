<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini

class Golongan extends Model
{
    use HasFactory; // Tambahkan ini

    protected $table = 'golongan';

    protected $fillable = [
        'kode',
        'nama_golongan',
        'gaji_pokok',
        'tunjangan_makan',
        'tunjangan_transport',
        'keterangan'
    ];

    public function pegawai(): HasMany
    {
        return $this->hasMany(Pegawai::class, 'golongan_id');
    }
}