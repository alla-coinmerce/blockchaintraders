<?php

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
        Schema::table('knowledge_base_news_articles', function (Blueprint $table) {
            $table->string('bottom_video_poster_original_file_name', 255)->nullable();
            $table->string('bottom_video_poster_storage_path', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('knowledge_base_news_articles', function (Blueprint $table) {
            $table->dropColumn('bottom_video_poster_original_file_name');
            $table->dropColumn('bottom_video_poster_storage_path');
        });
    }
};
