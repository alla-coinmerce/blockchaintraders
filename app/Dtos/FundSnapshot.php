<?php

namespace App\Dtos;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class FundSnapshot
{
    private CurrencyFormatter $currencyFormatter;

    public function __construct(
        private CoinInvestmentsSnapshot $coinInvestmentsSnapshot,
        private ParticipationInvestmentsSnapshot $participationInvestmentsSnapshot,
        private int $numberOfParticipations,
        private Carbon $sampleDateTime,
    )
    {
        $this->currencyFormatter = App::make(CurrencyFormatter::class);
    }

    public function coinInvestmentsSnapshot() { return $this->coinInvestmentsSnapshot; }

    public function participationInvestmentsSnapshot() { return $this->participationInvestmentsSnapshot; }

    public function totalInvestedValueInEurocents()
    {
        return ($this->coinInvestmentsSnapshot->totalCoinInvestmentsValueInEuroMilliCents() / 1000) + $this->participationInvestmentsSnapshot->totalParticipationInvestmentsValueInEuroCents();
    }

    public function formattedTotalInvestedValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrency($this->totalInvestedValueInEurocents());
    }

    public function numberOfParticipations() { return $this->numberOfParticipations; }

    public function sampleDateTime() { return $this->sampleDateTime; }

    public function fundValueInEuroCents()
    {
        // Calculate the value of the fund with prevention of division by 0 error
        $fundValue = $this->totalInvestedValueInEurocents(); 

        if($this->numberOfParticipations > 0)
        {
            $fundValue = $this->totalInvestedValueInEurocents() / $this->numberOfParticipations;
        }

        return $fundValue;
    }

    public function formattedFundValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrency($this->fundValueInEuroCents());
    }
}