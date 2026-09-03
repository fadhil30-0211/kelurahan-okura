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
    Schema::table('settings', function (Blueprint $table) {
        // Jam Pelayanan
        $table->string('jam_kerja_senin_kamis')->nullable()->default('08:00 - 16:00 WIB');
        $table->string('jam_kerja_jumat')->nullable()->default('08:00 - 16:30 WIB');
        $table->string('jam_kerja_sabtu_minggu')->nullable()->default('Libur');

        // Link Media Sosial
        $table->string('facebook_url')->nullable();
        $table->string('instagram_url')->nullable();
        $table->string('youtube_url')->nullable();
        $table->string('tiktok_url')->nullable();
    });
}

public function down(): void
{
    Schema::table('settings', function (Blueprint $table) {
        $table->dropColumn([
            'jam_kerja_senin_kamis',
            'jam_kerja_jumat',
            'jam_kerja_sabtu_minggu',
            'facebook_url',
            'instagram_url',
            'youtube_url',
            'tiktok_url',
        ]);
    });
}
};
