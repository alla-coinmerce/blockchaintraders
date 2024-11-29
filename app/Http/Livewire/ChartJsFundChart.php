<?php

namespace App\Http\Livewire;

use App\Services\ChartData;
use Livewire\Component;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class ChartJsFundChart extends Component
{
    public $timeScale = 'ytd';
    public bool $multiCurrency = true;
    public $euroLineColor = '#2c82be';
    public $dollarLineColor = '#66bd51';

    public $fundIdentifier;

    public $startDate = null;

    public function onTimeScaleChange($timeScale)
    {
        $fromDate = $this->startDate;

        switch($timeScale)
        {
            case '1w':
                $fromDate = Carbon::today()->subDays(7);
                break;
            case '1m':
                $fromDate = Carbon::today()->subMonth();
                break;
            case '1y':
                $fromDate = Carbon::today()->subYear();
                break;
            case 'ytd':
                $fromDate = Carbon::today()->subYear()->endOfYear()->startOfDay();
                break;
        }

        $charDataService = App::make(ChartData::class);

        $data = $charDataService->getChartData($this->fundIdentifier, $fromDate, $this->multiCurrency, $this->euroLineColor, $this->dollarLineColor);
        // Log::debug($data);

        $days = 0;
        if(array_key_exists(0, $data['datasets'][0]['data']))
        {
            $days = Carbon::today()->diffInDays($data['datasets'][0]['data'][0]['x']);
        }
        elseif($fromDate)
        {
            $days = Carbon::today()->diffInDays($fromDate);
        }

        if($days < 90)
        {
            $unit = 'day';
        }
        elseif($days < 367)
        {
            $unit = 'month';
        }
        else
        {
            $unit = 'year';
        }

        Log::debug($days);
        // Log::debug($timeScale);
        // Log::debug($unit);

        $this->timeScale = $timeScale;

        $this->emit('updateChart_'.$this->fundIdentifier, [
            'data' => $data,
            'unit' => $unit
        ]);
    }

    public function render()
    {
        return view('livewire.chart-js-fund-chart');
    }
}
