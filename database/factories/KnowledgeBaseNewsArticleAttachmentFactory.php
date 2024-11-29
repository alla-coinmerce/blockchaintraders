<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KnowledgeBaseArticleAttachment>
 */
class KnowledgeBaseNewsArticleAttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'knowledge_base_news_article_id' => fake()->numberBetween(1 ,20),
            'locale' => fake()->randomElement(['nl', 'en']),
            'original_file_name' => '',
            'storage_path' => ''
        ];
    }
}
