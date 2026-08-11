// database/migrations/2024_01_01_000007_create_layanan_surats_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanan_surats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tiket')->unique(); // ex: SRT-20260809-XXXX
            $table->string('jenis_surat'); // SKTM, SKU, Domisili, dll
            $table->string('nama_pemohon');
            $table->string('nik', 20);
            $table->string('no_hp');
            $table->text('keperluan');
            $table->json('berkas_persyaratan')->nullable(); // array path file upload warga
            $table->string('file_hasil')->nullable(); // surat jadi, diupload admin
            $table->enum('status', ['diajukan', 'diproses', 'disetujui', 'ditolak', 'selesai'])->default('diajukan');
            $table->text('catatan_admin')->nullable();
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('layanan_surats');
    }
};
