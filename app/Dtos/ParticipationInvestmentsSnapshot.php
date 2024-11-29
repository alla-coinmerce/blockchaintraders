<?php

namespace App\Dtos;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class ParticipationInvestmentsSnapshot
{
    private CurrencyFormatter $currencyFormatter;
    
    public function __construct(
        private Array $participationInvestmentSnapshots,
        private Carbon $sampleDateTime,
    )
    {
        $this->currencyFormatter = App::make(CurrencyFormatter::class);
    }

    public function participationInvestmentSnapshots() { return $this->participationInvestmentSnapshots; }

    public function sampleDateTime() { return $this->sampleDateTime; }

    public function totalParticipationInvestmentsValueInEuroCents()
    { 
        $totalParticipationInvestmentsValueInEuroCents = 0;
        foreach($this->participationInvestmentSnapshots as $participationInvestmentSnapshot)
        {
            $totalParticipationInvestmentsValueInEuroCents += $participationInvestmentSnapshot->investmentValueInEuroCents();
        }

        return $totalParticipationInvestmentsValueInEuroCents;
    }

    public function formattedTotalParticipationInvestmentsValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrency($this->totalParticipationInvestmentsValueInEuroCents());
    }
}