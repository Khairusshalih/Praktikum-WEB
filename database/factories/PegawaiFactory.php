<?php

namespace Database\Factories;

use App\Models\Golongan;
use App\Models\Pegawai;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pegawai>
 */
class PegawaiFactory extends Factory
{
    protected $model = Pegawai::class;

    public function definition(): array
    {
        $golonganIds = Golongan::pluck('id')->toArray();
        $departemens = ['IT', 'HRD', 'Keuangan', 'Marketing', 'Operasional', 'Sales', 'Research & Development'];
        $jabatans = ['Staff', 'Senior Staff', 'Supervisor', 'Manager', 'Assistant Manager', 'Junior Staff'];

        return [
            'nip' => 'PEG' . app(\Faker\Generator::class)->unique()->numerify('##########'),
            'nama' => app(\Faker\Generator::class)->name('male'),
            'email' => app(\Faker\Generator::class)->unique()->safeEmail(),
            'no_telepon' => fake()->numerify('08##########'),
            'alamat' => app(\Faker\Generator::class)->address(),
            'tanggal_masuk' => app(\Faker\Generator::class)->dateTimeBetween('-10 years', 'now')->format('Y-m-d'),
            'departemen' => app(\Faker\Generator::class)->randomElement($departemens),
            'jabatan' => app(\Faker\Generator::class)->randomElement($jabatans),
            'golongan_id' => app(\Faker\Generator::class)->randomElement($golonganIds),
            'status' => app(\Faker\Generator::class)->randomElement(['aktif', 'nonaktif']),
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

    public function departemen(string $dept): static
    {
        return $this->state(fn (array $attributes) => [
            'departemen' => $dept,
        ]);
    }
}
