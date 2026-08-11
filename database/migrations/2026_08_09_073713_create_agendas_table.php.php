<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_acara');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal');
            $table->string('waktu')->nullable(); // ex: "09:00 - 12:00 WIB"
            $table->string('lokasi')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('agendas');
    }
};
