<?php

namespace App\Dtos;

use App\Models\Fund;
use App\Services\CurrencyFormatter;
use App\Services\ReturnCalculator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class DashboardFund
{
    public $fundModel;
    public $name;
    public $returnIsPositive;
    public $participationValue;
    public $participationValueSinceStart;
    public $returnYtd;
    public $returnMonth;
    public $returnDay;

    private $returnCalculator;
    private $fundCurrentValueEurocents;

    /**
     * @param \App\Models\Fund $fund
     * @return void
     */
    public function __construct(Fund $fund, string $participationStartDate)
    {
        $this->fundModel = $fund;

        $currencyFormatter = App::make(CurrencyFormatter::class);
        $this->returnCalculator = App::make(ReturnCalculator::class);

        $this->name = $fund->name;

        $currentFundValue = $fund->current_fund_value;
        $this->fundCurrentValueEurocents = $currentFundValue ? $currentFundValue->value_eurocents : 0;
        $this->participationValue = $currencyFormatter->formatCurrency( $this->fundCurrentValueEurocents);
        
        $purchaseDateFundValue = $fund->fundValueAtDate($participationStartDate);
        $purchaseValueEuroCents = $purchaseDateFundValue ? $purchaseDateFundValue->value_eurocents : 0;
        
        $this->participationValueSinceStart = $this->returnFromDate($participationStartDate);

        $this->returnYtd = $this->returnFromDate(Carbon::create($fund->current_fund_value->date)->startOfYear()->subDays(1)->format('Y-m-d'));

        $this->returnMonth = $this->returnFromDate(Carbon::create($fund->current_fund_value->date)->subMonth()->format('Y-m-d'));

        $fundValueTwentyFourHourBeforeLastFundValue = $fund->fundValueTwentyFourHourBeforeLastFundValue;
        $this->returnDay = $this->returnFromDate($fundValueTwentyFourHourBeforeLastFundValue->date);

        $this->returnIsPositive = $this->fundCurrentValueEurocents >= $purchaseValueEuroCents;
    }

    private function returnFromDate($date)
    {
        $startFundValue = $this->fundModel->fundValueAtDate($date);
        $startvalue = $startFundValue ? $startFundValue->value_eurocents : 0;
        $return = $this->returnCalculator->calculateReturn($startvalue, $this->fundCurrentValueEurocents);
        
        return $this->returnCalculator->format($return);
    }
}