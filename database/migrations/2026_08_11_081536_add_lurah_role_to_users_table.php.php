// database/migrations/2024_02_03_000001_add_lurah_role_to_users_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin', 'lurah', 'staf') DEFAULT 'staf'");
    }

    public function down(): void {
        DB::statement("ALTER TABLE users MODIFY role ENUM('super_admin', 'staf') DEFAULT 'staf'");
    }
};
