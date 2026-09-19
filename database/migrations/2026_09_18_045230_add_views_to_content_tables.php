<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengecekan tabel beritas (hanya tambah jika kolom 'views' BELUM ADA)
        if (Schema::hasTable('beritas') && !Schema::hasColumn('beritas', 'views')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->unsignedBigInteger('views')->default(0)->after('status');
            });
        }

        // Pengecekan tabel pengumumans
        if (Schema::hasTable('pengumumans') && !Schema::hasColumn('pengumumans', 'views')) {
            Schema::table('pengumumans', function (Blueprint $table) {
                $table->unsignedBigInteger('views')->default(0)->after('status');
            });
        }

        // Pengecekan tabel wisatas
        if (Schema::hasTable('wisatas') && !Schema::hasColumn('wisatas', 'views')) {
            Schema::table('wisatas', function (Blueprint $table) {
                $table->unsignedBigInteger('views')->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('beritas') && Schema::hasColumn('beritas', 'views')) {
            Schema::table('beritas', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }

        if (Schema::hasTable('pengumumans') && Schema::hasColumn('pengumumans', 'views')) {
            Schema::table('pengumumans', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }

        if (Schema::hasTable('wisatas') && Schema::hasColumn('wisatas', 'views')) {
            Schema::table('wisatas', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }
    }
};
