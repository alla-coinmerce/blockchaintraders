<?php

namespace App\View\Components;

use App\Models\Fund;
use App\Models\FundValue;
use App\Services\ChartData;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class ChartJsFundChart extends Component
{
    public $timeScale = 'ytd';

    public $returnYtd = "-";
    public $returnMonthly = "-";
    public $returnSinceStart = "-";
    public $currentValue = "-";

    public array $labels = [];
    public array $datasets = [];

    public $startValue = 0;

    private $currentValueEurocents = 0;

    /**
     * Create a new component instance.
     */
    public function __construct(
        public $fundIdentifier,
        public bool $displayStatistics = true,
        public $startDate = null,
        public bool $multiCurrency = true,
        public string $euroLineColor = '#2c82be',
        public string $dollarLineColor = '#66bd51'
    )
    {
        $this->calcStatistics();

        $charDataService = App::make(ChartData::class);

        $fromDate = Carbon::today()->startOfYear()->subDays(1)->format('Y-m-d');
        if(Carbon::today()->dayOfYear() < 15)
        {
            $this->timeScale = '1y';
            $fromDate = Carbon::today()->subYear();
        }

        $data = $charDataService->getChartData($this->fundIdentifier, $fromDate, $this->multiCurrency, $this->euroLineColor, $this->dollarLineColor);

        $this->datasets = $data['datasets'];
        $this->labels = $data['labels'];
    }

    private function calcStatistics()
    {
        // Current value
        $currentFundValue = FundValue::where('fund_id', $this->fundIdentifier)
            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['06:50:00'])
            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['12:10:00'])
            ->orderBy('date_time', 'DESC')
            ->first();

        if($currentFundValue)
        {
            $this->currentValueEurocents = $currentFundValue->value_eurocents;
        }

        $this->currentValue = number_format($this->currentValueEurocents / 100, 2, ",", ".");

        // Since start
        $fund = Fund::find($this->fundIdentifier);

        $fromDate = null;
        if($this->startDate)
        {
            $fromDate = $this->startDate;
        }
        elseif($fund->startFundValue)
        {
            $fromDate = $fund->startFundValue->date;
        }

        $this->returnSinceStart = $this->calcReturn($fromDate);

        // YTD
        $this->returnYtd = $this->calcReturn(Carbon::today()->startOfYear()->subDays(1)->format('Y-m-d'));

        // Last month
        $this->returnMonthly = $this->calcReturn(Carbon::today()->subMonth());

        // Start value
        $first = FundValue::where('fund_id', $fund->id)
            ->when($fromDate , function(Builder $query) use ($fromDate){
                return $query->where('date_time', '>=', $fromDate);
            })
            ->orderBy('date_time', 'ASC')
            ->first();

        if($first)
        {
            $this->startValue = $first->value_eurocents / 100;
        }
    }

    private function calcReturn($fromDate = null)
    {
        $fundReturn = "-";

        $fromDateFundValue = FundValue::where('fund_id', $this->fundIdentifier)
            ->when($fromDate , function(Builder $query) use ($fromDate){
                return $query->where('date_time', '>=', $fromDate);
            })
            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) >= ?", ['10:50:00'])
            ->whereRaw("TIME(CONVERT_TZ(date_time,'+00:00','+01:00')) <= ?", ['12:10:00'])
            ->orderBy('date_time', 'ASC')
            ->first();

        if($fromDateFundValue)
        {
            $fromDateValue = $fromDateFundValue->value_eurocents;

            if($fromDateValue != 0)
            {
                $fundReturn = number_format( ( ($this->currentValueEurocents - $fromDateValue) / $fromDateValue) * 100 , 2, ",")."%";
            }
        }

        return $fundReturn;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.chart-js-fund-chart');
    }
}
