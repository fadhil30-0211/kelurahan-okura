<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('survei_kepuasan', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable(); // nullable, boleh anonim
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('saran')->nullable();
            $table->string('layanan_terkait')->nullable(); // surat, aduan, umum
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('survei_kepuasan');
    }
};
