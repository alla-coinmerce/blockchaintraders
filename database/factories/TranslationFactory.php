<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class TranslationFactory extends Factory
{
    private static $nextField = 'title';
    private static $nextLocale = 'nl';

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $field = self::$nextField;
        $locale = self::$nextLocale;
        $translation = '';

        if(self::$nextField === 'content')
        {
            self::$nextField = "title";

            $paragraphs = fake()->paragraphs(rand(2, 6));
            foreach ($paragraphs as $para)
            {
                $translation .= "<p>{$para}</p>";
            }

            if(self::$nextLocale === 'nl')
            {
                self::$nextLocale = 'en';
            }
            else
            {
                self::$nextLocale = 'nl';
            }
        }
        else
        {
            self::$nextField = "content";

            $translation = fake()->sentence(rand(5, 10));
        }

        return [
            'locale' => $locale,
            'field' => $field,
            'translation' => $translation
        ];
    }
}
