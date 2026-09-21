<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partisipasi_umkms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pemilik');
            $table->string('nama_umkm');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('no_hp');
            $table->text('alamat')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partisipasi_umkms');
    }
};
