<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Menambahkan kolom baru setelah kolom nama_website
            $table->string('nama_website_footer')->nullable()->after('nama_website');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            // Menghapus kolom jika migration di-rollback
            $table->dropColumn('nama_website_footer');
        });
    }
};
