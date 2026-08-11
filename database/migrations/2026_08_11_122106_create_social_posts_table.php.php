<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('social_posts', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['instagram', 'facebook', 'tiktok'])->default('instagram');
            $table->string('url');
            $table->string('caption')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('social_posts');
    }
};
