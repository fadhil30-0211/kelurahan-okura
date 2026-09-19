<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->text('deskripsi_sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->json('misi')->nullable(); // Disimpan dalam format array JSON
            $table->string('kecamatan')->default('Rumbai Timur');
            $table->string('kota')->default('Pekanbaru');
            $table->string('karakter_wilayah')->default('Tepian Sungai');
            $table->string('potensi')->default('Alam & Budaya');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('geojson_file')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
