<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FundValue>
 */
class FundValueFactory extends Factory
{
    private static $offset = 1000;

    private static $value = 100000;
    private static $exchange_rate = 0.8;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        self::$exchange_rate += fake()->randomFloat(4, -0.005, +0.0055);

        $time = Carbon::createFromTime(12, 00, 00, 'Europe/Amsterdam')->setTimezone('UTC')->format('H:i:s');
        $date = now()->subDays(self::$offset);
        $dateTime = Carbon::createFromTimestamp(strtotime($date.' '.$time));
        $eurocents = self::$value;
        $dollarcents = round($eurocents * self::$exchange_rate);

        self::$value += round(self::$value * fake()->randomFloat(3, -0.02, 0.02));
        self::$offset--;
        
        if(self::$offset % 1000 === 0)
        {
            self::$value = 100000;
            self::$offset = 1000;
            self::$exchange_rate = 0.8;
        }
        
        return [
            'date_time' => $dateTime,
            'date' => $date,
            'time' => $time,
            'value_eurocents' => $eurocents,
            'value_dollarcents' => $dollarcents
        ];
    }
}
