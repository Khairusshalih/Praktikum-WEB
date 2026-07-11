<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';

    protected $fillable = [
        'nip',
        'nama',
        'email',
        'no_telepon',
        'alamat',
        'tanggal_masuk',
        'departemen',
        'jabatan',
        'golongan_id',
        'status'
    ];

    /**
     * Relasi Many-to-One ke Golongan
     * Seorang Pegawai memiliki satu Golongan
     */
    public function golongan(): BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }

    /**
     * Relasi One-to-Many ke KomponenGaji
     * Seorang Pegawai memiliki banyak riwayat gaji
     */
    public function komponenGaji(): HasMany
    {
        return $this->hasMany(KomponenGaji::class, 'pegawai_id');
    }

    /**
     * Alias relasi riwayat gaji untuk tampilan pegawai.
     */
    public function riwayatGaji(): HasMany
    {
        return $this->komponenGaji();
    }
}
