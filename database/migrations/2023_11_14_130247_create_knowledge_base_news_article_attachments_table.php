<?php

use App\Models\KnowledgeBaseNewsArticle;
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
        Schema::create('knowledge_base_news_article_attachments', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(KnowledgeBaseNewsArticle::class);

            $table->string('locale', 8);
            
            $table->string('original_file_name', 255);
            $table->string('storage_path', 255);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_base_news_article_attachments');
    }
};
