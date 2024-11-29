<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('knowledge_base_news_articles', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255)->unique()->nullable();
            $table->string('slug', 255)->unique()->nullable();

            $table->boolean('published')->default(false);
            $table->date('publication_date')->nullable();

            $table->string('featured_img_original_file_name', 255)->nullable();
            $table->string('featured_img_storage_path', 255)->nullable();

            $table->string('featured_img_fw_original_file_name', 255)->nullable();
            $table->string('featured_img_fw_storage_path', 255)->nullable();

            $table->string('bottom_img_original_file_name', 255)->nullable();
            $table->string('bottom_img_storage_path', 255)->nullable();

            $table->string('bottom_video_original_file_name', 255)->nullable();
            $table->string('bottom_video_storage_path', 255)->nullable();

            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_base_news_articles');
    }
};
