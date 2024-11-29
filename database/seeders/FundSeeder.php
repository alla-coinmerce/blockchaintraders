<?php

namespace Database\Seeders;

use App\Models\Fund;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Fund::factory()
            ->count(3)
            ->hasFundValues(1000)
            ->create();
    }
}
