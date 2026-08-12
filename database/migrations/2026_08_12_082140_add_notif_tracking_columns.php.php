<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->timestamp('notif_terakhir_dikirim')->nullable()->after('tanggal_tanggapan');
        });
        Schema::table('layanan_surats', function (Blueprint $table) {
            $table->timestamp('notif_terakhir_dikirim')->nullable()->after('diproses_oleh');
        });
    }

    public function down(): void {
        Schema::table('pengaduans', function (Blueprint $table) {
            $table->dropColumn('notif_terakhir_dikirim');
        });
        Schema::table('layanan_surats', function (Blueprint $table) {
            $table->dropColumn('notif_terakhir_dikirim');
        });
    }
};
