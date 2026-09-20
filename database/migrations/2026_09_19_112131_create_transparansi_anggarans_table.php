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
    Schema::create('transparansi_anggarans', function (Blueprint $table) {
        $table->id();
        $table->year('tahun');
        $table->string('kategori'); // Contoh: Pendapatan, Belanja Pembiayaan, Program
        $table->string('nama_kegiatan');
        $table->bigInteger('anggaran');
        $table->bigInteger('realisasi')->default(0);
        $table->string('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transparansi_anggarans');
    }
};
