<?php

namespace App\Dtos;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Facades\App;

class ParticipationGroup
{
    public $name;
    public $participations;

    public $totalPurchaseValueEurosCents;

    public $totalCurrentValueEurosCents;
    public $formattedTotalCurrentValueEuros;

    public $secondLastTotalValueEurosCents;

    public $diffValueEuroCents;
    public $formattedDiffValueEuros;

    /**
     * @param string $groupName
     * @param \App\Dtos\Participation[] $participations
     */
    public function __construct(string $groupName, array $participations)
    {
        $currencyFormatter = App::make(CurrencyFormatter::class);

        $this->name = $groupName === '-' ? '' : $groupName;
        $this->participations = $participations;

        $this->totalPurchaseValueEurosCents = 0;
        $this->totalCurrentValueEurosCents = 0;
        $this->secondLastTotalValueEurosCents = 0;
        $this->diffValueEuroCents = 0;
        foreach($this->participations as $participation)
        {
            $this->totalPurchaseValueEurosCents += $participation->totalPurchaseValueEurosCents;
            $this->totalCurrentValueEurosCents += $participation->totalCurrentValueEurosCents;
            $this->secondLastTotalValueEurosCents += $participation->secondLastTotalValueEurosCents;
            $this->diffValueEuroCents += $participation->diffValueEuroCents;
        }

        $this->formattedTotalCurrentValueEuros = $currencyFormatter->formatCurrency($this->totalCurrentValueEurosCents);

        $this->formattedDiffValueEuros = $currencyFormatter->formatDiffCurrencyWithSymbol($this->diffValueEuroCents);
    }
}