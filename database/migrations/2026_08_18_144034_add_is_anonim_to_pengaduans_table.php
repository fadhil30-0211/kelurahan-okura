<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pengaduans', 'is_anonim')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->boolean('is_anonim')->default(false)->after('email');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pengaduans', 'is_anonim')) {
            Schema::table('pengaduans', function (Blueprint $table) {
                $table->dropColumn('is_anonim');
            });
        }
    }
};
