<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('label'); // Babinsa, Bhabinkamtibmas, Puskesmas, Pemadam
            $table->string('nomor_telepon');
            $table->string('ikon')->nullable(); // nama ikon (opsional)
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('emergency_contacts');
    }
};
