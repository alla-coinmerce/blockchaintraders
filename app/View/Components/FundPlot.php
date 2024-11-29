<?php

namespace App\View\Components;

use App\Models\Fund;
use App\Models\FundValue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class FundPlot extends Component
{
    /**
     * @var \App\Models\Fund
     */
    public $fund;

    /**
     * @var int
     */
    public $startIndex;

    /**
     * @var array xDataEuro
     */
    public $xDataEuro = Array();

    /**
     * @var array yDataEuro
     */
    public $yDataEuro = Array();

    /**
     * @var array xDataDollar
     */
    public $xDataDollar = Array();

    /**
     * @var array yDataDollar
     */
    public $yDataDollar = Array();

    /**
     *  @var int
     */
    public $fontSize = 10;

    /**
     * @var string
     */
    public $tickPrefix = "  ";

    /**
     *  @var int
     */
    public $marginLeft = 60;

    /**
     * Create a new component instance.
     *
     * @param \App\Models\Fund $fund
     * @return void
     */
    public function __construct(Fund $fund, int $fontSize = 10)
    {
        $this->fund = $fund;
        $this->fontSize = $fontSize;

        if($fontSize > 10)
        {
            $this->tickPrefix = "       ";
            $this->marginLeft = 120;
        }

        // $fundValues = $fund->fundValues
        //     ->when($fund->startFundValue, function(Collection $collection) use ($fund){
        //         return $collection->where('date', '>=', $fund->startFundValue->date);
        //     })
        //     ->sortBy('date');

        $timezone = 'Europe/Amsterdam';

        $isBeforeNoon = Carbon::now($timezone)->lt(Carbon::now($timezone)->setTime(12, 0));

        $fundValues = FundValue::where('fund_id', $fund->id)
            ->when($fund->startFundValue, function(Builder $query) use ($fund){
                return $query->where('date_time', '>=', $fund->startFundValue->date);
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

        $startDate = Carbon::today()->subYear();

        if(Carbon::today()->dayOfYear() < 15)
        {
            $startDate = $startDate->subYear();
        }

        $startDate = $startDate->endOfYear()->startOfDay();

        $this->startIndex = 0;
        foreach($fundValues as $fundValue)
        {
            $this->xDataEuro[] = "'".$fundValue->date."'";
            $this->yDataEuro[] = $fundValue->value_eurocents / 100;

            if($fundValue->value_dollarcents !== null)
            {
                $this->xDataDollar[] = "'".$fundValue->date."'";
                $this->yDataDollar[] = $fundValue->value_dollarcents / 100;
            }

            if($startDate->gt($fundValue->date))
            {
                $this->startIndex++;
            }
        }

        if($this->startIndex >= $fundValue->count())
        {
            Log::debug('StartIndex beyond end of array. Setting index to 0');
            $this->startIndex = 0;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.fund-plot');
    }
}
