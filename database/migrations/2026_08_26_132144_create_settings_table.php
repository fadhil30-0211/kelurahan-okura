<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Tab 1: Profil & Identitas
            $table->string('nama_website')->nullable();      // Ditambahkan
            $table->string('nama_instansi')->nullable();
            $table->string('singkatan')->nullable();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('telepon')->nullable();
            $table->string('whatsapp')->nullable();         // Ditambahkan
            $table->string('pesan_wa')->nullable();          // Ditambahkan
            $table->text('alamat')->nullable();
            $table->text('deskripsi_footer')->nullable();   // Ditambahkan

            // Tab 2: Kependudukan
            $table->integer('jumlah_penduduk')->default(0);

            // Tab 3: Peta & Lokasi
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('link_map')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
