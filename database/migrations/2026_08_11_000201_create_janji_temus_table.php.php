<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('janji_temus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique();
            $table->string('nama_pemohon');
            $table->string('no_hp');
            $table->text('keperluan');
            $table->date('tanggal_diinginkan');
            $table->string('waktu_diinginkan')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('janji_temus');
    }
};
