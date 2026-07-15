<?php

namespace Database\Factories;

use App\Models\Golongan;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;

    public function definition(): array
    {
        $golonganIds = Golongan::pluck('id')->toArray();

        $departemens = ['IT', 'HRD', 'Keuangan', 'Marketing', 'Operasional', 'Sales', 'Research & Development'];
        $jabatans = ['Staff', 'Senior Staff', 'Supervisor', 'Manager', 'Assistant Manager', 'Junior Staff'];

        return [
            'nip' => 'PEG' . fake()->unique()->numerify('#########'),
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'no_telepon' => fake()->numerify('08##########'), // Format 08 + 10 digit angka
            'alamat' => fake()->address(),
            'tanggal_masuk' => fake()->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'departemen' => fake()->randomElement($departemens),
            'jabatan' => fake()->randomElement($jabatans),
            'golongan_id' => fake()->randomElement($golonganIds),
            'status' => fake()->randomElement(['aktif', 'nonaktif']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function aktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'aktif',
        ]);
    }

    public function nonaktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'nonaktif',
        ]);
    }
}