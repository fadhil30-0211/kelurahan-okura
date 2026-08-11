// database/migrations/2024_01_01_000002_create_beritas_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('beritas', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->string('kategori')->default('umum'); // umum, kegiatan, sosial
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // penulis
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedInteger('views')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('beritas');
    }
};
