<?php

namespace App\Services;

use App\Models\Fund;
use App\Models\FundValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class ChartData
{
    public function getChartData($fundId, $fromDate, $multiCurrency, $euroLineColor, $dollarLineColor)
    {
        $fund = Fund::find($fundId);

        $timezone = 'Europe/Amsterdam';

        $isBeforeNoon = Carbon::now($timezone)->lt(Carbon::now($timezone)->setTime(12, 0));

        // Log::debug("Using start date ".$fromDate);

        $fundValues = FundValue::where('fund_id', $fund->id)
            ->when($fromDate, function(Builder $query) use ($fromDate){
                return $query->where('date_time', '>=', $fromDate);
            })
            ->when($isBeforeNoon, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where(function (Builder $query) {
                        $query->whereDate('date_time', '<', Carbon::today())
                            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['10:50:00'])
                            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['12:10:00']);
                    })
                    ->orWhere(function (Builder $query) {
                        $query->whereDate('date_time', Carbon::today())
                            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['06:50:00'])
                            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['08:10:00']);
                    });
                });
            }, function (Builder $query) {
                $query->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['10:50:00'])
                    ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['12:10:00']);
            })
            ->orderBy('date_time', 'ASC')
            ->get();

        $labels = [];
        $euroData = [];
        $dollarData = [];
        foreach($fundValues as $fundValue)
        {
            $label = $fundValue->date_time->setTimeZone('Europe/Amsterdam')->format("Y-m-d H:i");
            $labels[] = $label;
            $euroData[] = ['x' => $label, 'y' => $fundValue->value_eurocents / 100];

            if($multiCurrency &&
                ($fundValue->value_dollarcents !== null) )
            {
                $dollarData[] = ['x' => $label, 'y' => $fundValue->value_dollarcents / 100];
            }
        }

        $datasets = [
            [
                'label' => '€',
                'borderColor' => $euroLineColor,
                'borderWidth' => 2,
                'showLine' => true,
                'lineTension' => 0,
                'fill' => false,
                'pointHoverRadius' => 5,
                'pointHoverBackgroundColor' => '#0082FF',
                'pointHoverBorderColor' => 'rgba(0,130,255,0.5)',
                'pointHoverBorderWidth' => 10,
                'pointBackgroundColor' => 'red',
                'data' => $euroData
            ],
            [
                'label' => '$',
                'borderColor' => $dollarLineColor,
                'borderWidth' => 2,
                'showLine' => true,
                'lineTension' => 0,
                'fill' => false,
                'pointHoverRadius' => 5,
                'pointHoverBackgroundColor' => '#0082FF',
                'pointHoverBorderColor' => 'rgba(0,130,255,0.5)',
                'pointHoverBorderWidth' => 10,
                'pointBackgroundColor' => 'red',
                'data' => $dollarData
            ],
        ];
        
        return [
            'datasets' => $datasets,
            'labels' => $labels
        ];
    }
}