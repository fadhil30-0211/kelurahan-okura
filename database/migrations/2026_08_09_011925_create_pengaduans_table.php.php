// database/migrations/2024_01_01_000006_create_pengaduans_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique(); // ex: ADU-20260809-XXXX
            $table->string('nama_pelapor');
            $table->string('nik', 20)->nullable();
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->string('kategori'); // infrastruktur, sosial, keamanan, lingkungan
            $table->string('judul_aduan');
            $table->text('isi_aduan');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['diterima', 'diproses', 'selesai', 'ditolak'])->default('diterima');
            $table->text('tanggapan_admin')->nullable();
            $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('tanggal_tanggapan')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('pengaduans');
    }
};
