<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PegawaiSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Pegawai::truncate();
        Schema::enableForeignKeyConstraints();

        $this->command->info(' Memulai pengisian data pegawai...');

        Pegawai::factory()
            ->count(100)
            ->aktif()
            ->create();

        $this->command->info(' Berhasil membuat 100 pegawai aktif!');

        Pegawai::factory()
            ->count(10)
            ->nonaktif()
            ->create();

        $this->command->info(' Berhasil membuat 10 pegawai nonaktif!');

        $stats = Pegawai::selectRaw('golongan_id, count(*) as total')
            ->groupBy('golongan_id')
            ->with('golongan')
            ->get();

        $this->command->info("\n Statistik Pegawai per Golongan:");
        foreach ($stats as $stat) {
            $this->command->line("- Golongan {$stat->golongan->kode}: {$stat->total} pegawai");
        }
    }
}
