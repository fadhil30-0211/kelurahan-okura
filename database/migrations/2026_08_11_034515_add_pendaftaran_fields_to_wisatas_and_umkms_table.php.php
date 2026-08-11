// database/migrations/2024_02_02_000001_add_pendaftaran_fields_to_wisatas_and_umkms_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->string('kode_tiket')->nullable()->unique()->after('id');
            $table->string('nama_pengaju')->nullable()->after('kontak');
            $table->string('no_hp_pengaju')->nullable()->after('nama_pengaju');
            $table->enum('sumber', ['admin', 'warga'])->default('admin')->after('no_hp_pengaju');
        });

        Schema::table('umkms', function (Blueprint $table) {
            $table->string('kode_tiket')->nullable()->unique()->after('id');
            $table->string('nama_pengaju')->nullable()->after('no_hp');
            $table->string('no_hp_pengaju')->nullable()->after('nama_pengaju');
            $table->enum('sumber', ['admin', 'warga'])->default('admin')->after('no_hp_pengaju');
        });

        // Perluas enum status supaya ada 'pending' (perlu raw SQL karena MySQL enum)
        DB::statement("ALTER TABLE wisatas MODIFY status ENUM('pending', 'aktif', 'nonaktif') DEFAULT 'aktif'");
        DB::statement("ALTER TABLE umkms MODIFY status ENUM('pending', 'aktif', 'nonaktif') DEFAULT 'aktif'");
    }

    public function down(): void {
        Schema::table('wisatas', function (Blueprint $table) {
            $table->dropColumn(['kode_tiket', 'nama_pengaju', 'no_hp_pengaju', 'sumber']);
        });
        Schema::table('umkms', function (Blueprint $table) {
            $table->dropColumn(['kode_tiket', 'nama_pengaju', 'no_hp_pengaju', 'sumber']);
        });
        DB::statement("ALTER TABLE wisatas MODIFY status ENUM('aktif', 'nonaktif') DEFAULT 'aktif'");
        DB::statement("ALTER TABLE umkms MODIFY status ENUM('aktif', 'nonaktif') DEFAULT 'aktif'");
    }
};
