<?php

namespace Database\Factories;

use App\Services\StringToSlugConverter;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Fund>
 */
class FundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $converter = App::make(StringToSlugConverter::class);

        $name = fake()->unique()->randomElement([
            'Fund A',
            'Fund B',
            'Fund C',
            'Liquidity Fund X',
            'Liquidity Fund Y',
            'Liquidity Fund Z',
            'Growth Fund Q',
            'Growth Fund R',
            'Growth Fund S'
        ]);

        $slug = $converter->getSlugFromString($name);

        return [
            'name' => $name,
            'slug' => $slug,
            'public' => fake()->boolean(70)
        ];
    }
}
