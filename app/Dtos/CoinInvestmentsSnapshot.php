<?php

namespace App\Dtos;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class CoinInvestmentsSnapshot
{
    private CurrencyFormatter $currencyFormatter;

    public function __construct(
        private Array $coinInvestmentSnapshots,
        private Carbon $sampleDateTime,
    )
    {
        $this->currencyFormatter = App::make(CurrencyFormatter::class);

        usort($this->coinInvestmentSnapshots, [$this, 'sortByValue']);
    }

    private function sortByValue($a, $b)
    {
        if($a->investmentValueInEuroMilliCents() === $b->investmentValueInEuroMilliCents())
        {
            return 0;
        }

        return ($a->investmentValueInEuroMilliCents() > $b->investmentValueInEuroMilliCents()) ? -1 : 1;
    }

    public function coinInvestmentSnapshots() { return $this->coinInvestmentSnapshots; }

    public function sampleDateTime() { return $this->sampleDateTime; }

    public function totalCoinInvestmentsValueInEuroMilliCents()
    { 
        $totalCoinInvestmentsValueInEuroMilliCents = 0;
        foreach($this->coinInvestmentSnapshots as $coinInvestmentSnapshot)
        {
            $totalCoinInvestmentsValueInEuroMilliCents += $coinInvestmentSnapshot->investmentValueInEuroMilliCents();
        }

        return $totalCoinInvestmentsValueInEuroMilliCents;
    }
    
    public function formattedTotalCoinInvestmentsValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrencyHighPrecion($this->totalCoinInvestmentsValueInEuroMilliCents());
    }
}