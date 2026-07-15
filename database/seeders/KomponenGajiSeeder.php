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

        $this->command->info('Memulai pengisian data penggajian...');

        $pegawaiList = Pegawai::all();

        foreach ($pegawaiList as $pegawai) {
            $this->command->line("Memproses pegawai: {$pegawai->nama}");

            $golongan = $pegawai->golongan;

            // Buat data untuk 12 bulan di tahun 2024
            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $tahun = 2024;

                $gajiPokok = $golongan->gaji_pokok;
                $tunjanganMakan = $golongan->tunjangan_makan;
                $tunjanganTransport = $golongan->tunjangan_transport;

                $tunjanganLainnya = rand(0, 500000);
                $potonganAbsensi = rand(0, 200000);
                $potonganLainnya = rand(0, 300000);

                $totalPotongan = $potonganAbsensi + $potonganLainnya;
                $gajiBersih = $gajiPokok + $tunjanganMakan + $tunjanganTransport + $tunjanganLainnya - $totalPotongan;

                $tanggalGaji = date('Y-m-d', strtotime("$tahun-$bulan-" . rand(1, 28)));
                $statusList = ['draft', 'diproses', 'selesai'];
                $status = $statusList[array_rand($statusList)];

                KomponenGaji::create([
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
                    'status' => $status,
                    'tanggal_gaji' => $tanggalGaji,
                ]);
            }
        }

        $totalGaji = KomponenGaji::count();
        $this->command->info("Berhasil membuat {$totalGaji} data penggajian!");

        $this->command->info("Ringkasan Total Gaji per Bulan (2024):");
        $summary = KomponenGaji::selectRaw('bulan, SUM(gaji_bersih) as total')
            ->where('tahun', 2024)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();

        $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        foreach ($summary as $item) {
            $this->command->line("- {$namaBulan[$item->bulan - 1]}: Rp " . number_format($item->total, 0, ',', '.'));
        }
    }
}