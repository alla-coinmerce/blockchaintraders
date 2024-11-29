<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participation>
 */
class ParticipationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $tags = ['Personal Participations', 'Company Participations', 'Personal', 'Private', 'Company', ''];
        $date = fake()->dateTimeBetween(now()->subDays(1000), now());

        return [
            'user_id' => fake()->numberBetween(1, 23),
            'fund_id' => fake()->numberBetween(1, 3),
            'tag_id' => fake()->numberBetween(1, 4),
            'qty' => fake()->numberBetween(1, 20),
            'purchase_date' => $date->format("Y-m-d")
        ];
    }
}
