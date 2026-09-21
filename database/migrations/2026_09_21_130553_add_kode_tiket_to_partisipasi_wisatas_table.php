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
        Schema::table('partisipasi_wisatas', function (Blueprint $table) {
            // Menambahkan kolom kode_tiket setelah id atau kolom lain
            $table->string('kode_tiket', 20)->nullable()->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partisipasi_wisatas', function (Blueprint $table) {
            $table->dropColumn('kode_tiket');
        });
    }
};
