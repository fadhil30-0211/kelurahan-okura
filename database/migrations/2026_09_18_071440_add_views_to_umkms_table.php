<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('umkms') && !Schema::hasColumn('umkms', 'views')) {
            Schema::table('umkms', function (Blueprint $table) {
                $table->unsignedBigInteger('views')->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('umkms') && Schema::hasColumn('umkms', 'views')) {
            Schema::table('umkms', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }
    }
};
