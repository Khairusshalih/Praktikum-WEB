<?php

namespace Database\Factories;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

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

        $tunjanganLainnya = fake()->numberBetween(0, 500000);
        $potonganAbsensi = fake()->numberBetween(0, 200000);
        $potonganLainnya = fake()->numberBetween(0, 300000);

        $totalPotongan = $potonganAbsensi + $potonganLainnya;
        $gajiBersih = $gajiPokok + $tunjanganMakan + $tunjanganTransport + $tunjanganLainnya - $totalPotongan;

        $bulan = fake()->numberBetween(1, 12);
        $tahun = fake()->numberBetween(2023, 2025);
        $tanggalGaji = fake()->dateTimeBetween("$tahun-$bulan-01", "$tahun-$bulan-28")->format('Y-m-d');

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
            'status' => fake()->randomElement(['draft', 'diproses', 'selesai']),
            'tanggal_gaji' => $tanggalGaji,
        ];
    }

    public function bulanTahun(int $bulan, int $tahun): static
    {
        return $this->state(fn (array $attributes) => [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'tanggal_gaji' => fake()->dateTimeBetween("$tahun-$bulan-01", "$tahun-$bulan-28")->format('Y-m-d'),
        ]);
    }

    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
        ]);
    }
}