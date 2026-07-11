<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('komponen_gaji', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pegawai_id')
                ->constrained('pegawai')
                ->onDelete('cascade');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->bigInteger('gaji_pokok');
            $table->bigInteger('tunjangan_makan');
            $table->bigInteger('tunjangan_transport');
            $table->bigInteger('tunjangan_lainnya')->default(0);
            $table->bigInteger('potongan_absensi')->default(0);
            $table->bigInteger('potongan_lainnya')->default(0);
            $table->bigInteger('total_potongan')->default(0);
            $table->bigInteger('gaji_bersih');
            $table->enum('status', ['draft', 'diproses', 'selesai'])->default('draft');
            $table->date('tanggal_gaji');
            $table->timestamps();
            $table->unique(['pegawai_id', 'bulan', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komponen_gaji');
    }
};
