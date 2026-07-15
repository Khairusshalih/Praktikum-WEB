<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini

class Pegawai extends Model
{
    use HasFactory; // Tambahkan ini

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

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    public function golongan(): BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'golongan_id');
    }

    public function komponenGaji(): HasMany
    {
        return $this->hasMany(KomponenGaji::class, 'pegawai_id');
    }

    public function sudahDigaji(int $bulan, int $tahun): bool
    {
        return $this->komponenGaji()
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();
    }

    public function getGajiTerakhirAttribute()
    {
        return $this->komponenGaji()
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->first();
    }
}