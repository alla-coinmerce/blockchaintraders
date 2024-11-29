<?php

namespace App\Console\Commands;

use App\Models\FundValue;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class timezoneTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:timezone-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $timezone = 'Europe/Amsterdam';

        $isBeforeNoon = Carbon::now($timezone)->lt(Carbon::now($timezone)->setTime(12, 0));


        $fundValues = FundValue::where('fund_id', 1)
            ->when($isBeforeNoon, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where(function (Builder $query) {
                        $query->whereDate('date_time', '<', Carbon::today())
                            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['10:50:00'])
                            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['12:10:00']);
                    })
                    ->orWhere(function (Builder $query) {
                        $query->whereDate('date_time', Carbon::today())
                            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['08:10:00']);
                    });
                });
            }, function (Builder $query) {
                $query->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['10:50:00'])
                    ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['12:10:00']);
            })
            // ->whereDate('date_time', '>', Carbon::today()->subDays(20))
            ->orderBy('date_time', 'ASC')
            ->get();

        foreach($fundValues as $fundValue)
        {
            Log::debug($fundValue->fund_id.' date_time: '.$fundValue->date_time.' ,  date_time Europe/Amsterdam: '.Carbon::make($fundValue->date_time)->setTimezone($timezone));
        }
    }
}