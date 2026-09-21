<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('partisipasi_umkms', function (Blueprint $table) {
            $table->string('kode_tiket')->unique()->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('partisipasi_umkms', function (Blueprint $table) {
            $table->dropColumn('kode_tiket');
        });
    }
};
