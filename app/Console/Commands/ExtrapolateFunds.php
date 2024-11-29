<?php

namespace App\Console\Commands;

use App\Models\Fund;
use App\Services\Time;
use Carbon\Carbon as CarbonCarbon;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ExtrapolateFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:extrapolate-funds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If automatic extrapolation for a fund is enabled update the fund value.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $time = Carbon::now('Europe/Amsterdam');
        Log::debug('Running auto extrapolation task at '.$time.' Europe/Amsterdam');

        foreach(Fund::all() as $fund)
        {
            if($fund->extrapolate_enabled)
            {
                if($fund->extrapolation_factor)
                {
                    $currentFundValue = $fund->current_fund_value;

                    $currentFundValueDate = Carbon::parse($currentFundValue->date);

                    if($currentFundValueDate->isToday())
                    {
                        Log::debug('Todays value for '.$fund->name.'. is already set. Extrapolation canceled.');
                    }
                    else
                    {
                        Log::debug('Auto extrapolating fund '.$fund->name.' with factor '.$fund->extrapolation_factor);
                        Log::debug('New value based on value of date '.$currentFundValue->date.' with value '.$currentFundValue->value_eurocents.' eurocents.');

                        $dateTime = Carbon::now();

                        $newFundValue = $fund->fundValues()->create([
                            'value_eurocents' => $currentFundValue->value_eurocents * $fund->extrapolation_factor,
                            'value_dollarcents' => ($currentFundValue->value_dollarcents !== null) ? $currentFundValue->value_dollarcents * $fund->extrapolation_factor : null,
                            'date_time' => $dateTime,
                            'date' => $dateTime->format('Y-m-d'),
                            'time' => $dateTime->format('H:i:s')
                        ]);

                        Log::debug('Created new value for fund '.$fund->name.'. New value in eurocents: '.$newFundValue->value_eurocents);
                    }
                }
                else
                {
                    Log::debug('Extrapolation enabled, but extrapolationfactor not set for fund '.$fund->name.'. Extrapolation canceled.');
                }
            }
        }
    }
}
