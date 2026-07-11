<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KomponenGaji extends Model
{
    use HasFactory;
    protected $table = 'komponen_gaji';

    protected $fillable = [
        'pegawai_id',
        'bulan',
        'tahun',
        'gaji_pokok',
        'tunjangan_makan',
        'tunjangan_transport',
        'tunjangan_lainnya',
        'potongan_absensi',
        'potongan_lainnya',
        'total_potongan',
        'gaji_bersih',
        'status',
        'tanggal_gaji'
    ];

    /**
     * Relasi Many-to-One ke Pegawai
     */
    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }
}
