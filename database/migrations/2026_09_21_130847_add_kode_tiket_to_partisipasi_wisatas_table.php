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
            // Hanya tambahkan jika kolom 'kode_tiket' belum ada
            if (!Schema::hasColumn('partisipasi_wisatas', 'kode_tiket')) {
                $table->string('kode_tiket', 20)->nullable()->unique()->after('id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('partisipasi_wisatas', function (Blueprint $table) {
            if (Schema::hasColumn('partisipasi_wisatas', 'kode_tiket')) {
                $table->dropColumn('kode_tiket');
            }
        });
    }
};
