<?php

namespace Database\Seeders;

use App\Models\KnowledgeBaseNewsArticle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KnowledgeBaseNewsArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KnowledgeBaseNewsArticle::factory()
            ->count(20)
            ->hasTranslations(4)
            // ->hasAttachments(2)
            ->create();
    }
}
