<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Tambahkan ini

class KomponenGaji extends Model
{
    use HasFactory; // Tambahkan ini

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

    protected $casts = [
        'tanggal_gaji' => 'date',
        'bulan' => 'integer',
        'tahun' => 'integer',
        'gaji_pokok' => 'integer',
        'tunjangan_makan' => 'integer',
        'tunjangan_transport' => 'integer',
        'tunjangan_lainnya' => 'integer',
        'potongan_absensi' => 'integer',
        'potongan_lainnya' => 'integer',
        'total_potongan' => 'integer',
        'gaji_bersih' => 'integer',
    ];

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function getNamaBulanAttribute(): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $bulan[$this->bulan] ?? 'Unknown';
    }

    public function getTotalTunjanganAttribute(): int
    {
        return $this->tunjangan_makan + $this->tunjangan_transport + $this->tunjangan_lainnya;
    }

    public function getGajiPokokFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->gaji_pokok, 0, ',', '.');
    }

    public function getGajiBersihFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->gaji_bersih, 0, ',', '.');
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            $model->total_potongan = $model->potongan_absensi + $model->potongan_lainnya;
            $model->gaji_bersih = $model->gaji_pokok + $model->tunjangan_makan + $model->tunjangan_transport + $model->tunjangan_lainnya - $model->total_potongan;
        });
    }
}