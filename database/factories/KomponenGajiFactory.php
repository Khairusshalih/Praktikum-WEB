<?php

namespace Database\Factories;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<KomponenGaji>
 */
class KomponenGajiFactory extends Factory
{
    protected $model = KomponenGaji::class;

    public function definition(): array
    {
        $pegawai = Pegawai::inRandomOrder()->first();
        if (!$pegawai) {
            $pegawai = Pegawai::factory()->create();
        }

        $golongan = $pegawai->golongan;
        $gajiPokok = $golongan->gaji_pokok;
        $tunjanganMakan = $golongan->tunjangan_makan;
        $tunjanganTransport = $golongan->tunjangan_transport;
        $tunjanganLainnya = app(\Faker\Generator::class)->numberBetween(0, 500000);
        $potonganAbsensi = app(\Faker\Generator::class)->numberBetween(0, 200000);
        $potonganLainnya = app(\Faker\Generator::class)->numberBetween(0, 300000);
        $totalPotongan = $potonganAbsensi + $potonganLainnya;
        $gajiBersih = $gajiPokok + $tunjanganMakan + $tunjanganTransport + $tunjanganLainnya - $totalPotongan;

        $bulan = app(\Faker\Generator::class)->numberBetween(1, 12);
        $tahun = app(\Faker\Generator::class)->numberBetween(2023, 2025);
        $tanggalGaji = app(\Faker\Generator::class)->dateTimeBetween("$tahun-$bulan-01", "$tahun-$bulan-28")->format('Y-m-d');

        return [
            'pegawai_id' => $pegawai->id,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'gaji_pokok' => $gajiPokok,
            'tunjangan_makan' => $tunjanganMakan,
            'tunjangan_transport' => $tunjanganTransport,
            'tunjangan_lainnya' => $tunjanganLainnya,
            'potongan_absensi' => $potonganAbsensi,
            'potongan_lainnya' => $potonganLainnya,
            'total_potongan' => $totalPotongan,
            'gaji_bersih' => $gajiBersih,
            'status' => app(\Faker\Generator::class)->randomElement(['draft', 'diproses', 'selesai']),
            'tanggal_gaji' => $tanggalGaji,
        ];
    }

    public function bulanTahun(int $bulan, int $tahun): static
    {
        return $this->state(fn (array $attributes) => [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_gaji' => app(\Faker\Generator::class)->dateTimeBetween("$tahun-$bulan-01", "$tahun-$bulan-28")->format('Y-m-d'),
        ]);
    }

    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
        ]);
    }
}
