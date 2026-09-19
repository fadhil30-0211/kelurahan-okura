<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hanya tambah jika kolom 'views' BELUM ADA
        if (Schema::hasTable('pengumumans') && !Schema::hasColumn('pengumumans', 'views')) {
            Schema::table('pengumumans', function (Blueprint $table) {
                $table->unsignedBigInteger('views')->default(0)->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pengumumans') && Schema::hasColumn('pengumumans', 'views')) {
            Schema::table('pengumumans', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }
    }
};
