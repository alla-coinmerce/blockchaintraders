<?php

namespace Database\Factories;

use App\Services\StringToSlugConverter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KnowledgeBaseArticle>
 */
class KnowledgeBaseNewsArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(rand(5, 5));

        $converter = App::make(StringToSlugConverter::class);

        $published = fake()->boolean(80);

        $images = [
            'dummies/dummy1.jpg',
            'dummies/dummy2.jpg',
            'dummies/dummy3.jpg',
            'dummies/dummy4.jpg',
            'dummies/dummy5.jpg',
            'dummies/dummy6.jpg'
        ];

        $add_bottom_image = fake()->boolean(30);

        $img1 = fake()->randomElement($images);
        $img2 = fake()->randomElement($images);
        $img3 = fake()->randomElement($images);

        return [
            'title' => $title,
            'slug' => $converter->getSlugFromString($title),

            'published' => $published,
            'publication_date'=> $published ? fake()->date() : null,

            'featured_img_original_file_name' => $img1,
            'featured_img_storage_path' => Storage::putFile('knowledge-base-assets/images', $img1),

            'featured_img_fw_original_file_name' => $img1,
            'featured_img_fw_storage_path' => Storage::putFile('knowledge-base-assets/images', $img2),

            'bottom_img_original_file_name' => $add_bottom_image ? $img3 : '',
            'bottom_img_storage_path' => $add_bottom_image ? Storage::putFile('knowledge-base-assets/images', $img3) : '',

            'bottom_video_original_file_name' => '',
            'bottom_video_storage_path' => '',

            'created_by' => null,
            'updated_by' => null
        ];
    }
}
