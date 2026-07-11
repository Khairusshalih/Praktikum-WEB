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
        Schema::create('pegawai', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 20)->unique();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('no_telepon', 15)->nullable();
            $table->text('alamat')->nullable();
            $table->date('tanggal_masuk');
            $table->string('departemen', 50);
            $table->string('jabatan', 50);
            $table->foreignId('golongan_id')
                ->constrained('golongan')
                ->onDelete('restrict')
                ->onUpdate('cascade');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};
