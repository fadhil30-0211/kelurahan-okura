<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelurahan')->default('Tebing Tinggi Okura');
            $table->text('visi')->nullable();
            $table->text('sub_visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('deskripsi_sejarah')->nullable();
            $table->string('kecamatan')->default('Rumbai Timur');
            $table->string('kota')->default('Pekanbaru');
            $table->string('karakter_wilayah')->default('Tepian Sungai');
            $table->string('potensi')->default('Alam & Budaya');

            // Kolom Peta Wilayah
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('geojson_file')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
