<?php

namespace Database\Seeders;

use App\Models\KomponenGaji;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class KomponenGajiSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        KomponenGaji::truncate();
        Schema::enableForeignKeyConstraints();

        $this->command->info(' Memulai pengisian data penggajian...');

        $pegawaiList = Pegawai::all();

        foreach ($pegawaiList as $pegawai) {
            $this->command->line("Memproses pegawai: {$pegawai->nama}");
            for ($i = 1; $i <= 12; $i++) {
                KomponenGaji::factory()
                    ->bulanTahun($i, now()->year)
                    ->selesai()
                    ->create([
                        'pegawai_id' => $pegawai->id
                    ]);
            }
        }

        $totalGaji = KomponenGaji::count();
        $this->command->info(" Berhasil membuat {$totalGaji} data penggajian!");

        $year = now()->year;
        $this->command->info("\n Ringkasan Total Gaji per Bulan ({$year}):");
        $summary = KomponenGaji::selectRaw('bulan, SUM(gaji_bersih) as total')
            ->where('tahun', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        foreach ($summary as $item) {
            $this->command->line("- {$namaBulan[$item->bulan - 1]}: Rp " .
                number_format($item->total, 0, ',', '.'));
        }
    }
}
