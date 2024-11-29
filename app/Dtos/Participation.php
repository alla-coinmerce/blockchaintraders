<?php

namespace App\Dtos;

use App\Models\Fund;
use App\Models\Participation as ModelsParticipation;
use App\Services\CurrencyFormatter;
use App\Services\ReturnCalculator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class Participation
{
    public $sequenceNumber;
    public $purchaseDate;
    public $qty;

    public $purchaseValueEuroCents;
    public $formattedPurchaseValueEuros;

    public $currentValueEurosCents;
    public $formattedCurrentValueEuros;

    public $totalPurchaseValueEurosCents;

    public $totalCurrentValueEurosCents;
    public $formattedTotalCurrentValueEuros;

    public $secondLastTotalValueEurosCents;

    public $diffValueEuroCents;
    public $formattedDiffValueEuros;

    public $achievedReturn;
    public $formattedAchievedReturn;

    /**
     * @param \App\Models\Participation $participation
     * @param int $sequence_number
     * @param \App\Models\Fund $fund
     */
    public function __construct(ModelsParticipation $participation, int $sequenceNumber, Fund $fund)
    {
        $currencyFormatter = App::make(CurrencyFormatter::class);
        $returnCalculator = App::make(ReturnCalculator::class);

        $this->sequenceNumber = $sequenceNumber;
        $this->purchaseDate = date('d-m-Y', strtotime($participation->purchase_date));
        $this->qty = $participation->qty;

        $purchaseDateFundValue = $participation->purchaseDateFundValue;
        
        $this->purchaseValueEuroCents = $purchaseDateFundValue ? $purchaseDateFundValue->value_eurocents : 0;
        $this->formattedPurchaseValueEuros = $currencyFormatter->formatCurrency($this->purchaseValueEuroCents);

        $this->currentValueEurosCents = $fund->currentFundValue->value_eurocents;
        $this->formattedCurrentValueEuros= $currencyFormatter->formatCurrency($this->currentValueEurosCents);

        $this->totalPurchaseValueEurosCents = $participation->qty * $this->purchaseValueEuroCents;

        $this->totalCurrentValueEurosCents = $participation->qty * $this->currentValueEurosCents;
        $this->formattedTotalCurrentValueEuros = $currencyFormatter->formatCurrency($this->totalCurrentValueEurosCents);

        $fundValueTwentyFourHourBeforeLastFundValue = $fund->fundValueTwentyFourHourBeforeLastFundValue;
        $this->secondLastTotalValueEurosCents = $participation->qty * ($fundValueTwentyFourHourBeforeLastFundValue ? $fundValueTwentyFourHourBeforeLastFundValue->value_eurocents : 0);

        $this->diffValueEuroCents = $participation->qty * ($this->currentValueEurosCents - $this->purchaseValueEuroCents);
        $this->formattedDiffValueEuros = $currencyFormatter->formatDiffCurrencyWithSymbol($this->diffValueEuroCents);

        $this->achievedReturn = $returnCalculator->calculateReturn($this->purchaseValueEuroCents, $this->currentValueEurosCents);
        $this->formattedAchievedReturn = $returnCalculator->format($this->achievedReturn);
    }
}