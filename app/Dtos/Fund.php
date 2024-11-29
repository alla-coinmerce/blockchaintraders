<?php

namespace App\Dtos;

use App\Models\Fund as ModelsFund;
use App\Services\CurrencyFormatter;
use App\Services\ReturnCalculator;
use Illuminate\Support\Facades\App;

class Fund
{
    public $name;
    public $slug;
    public $model;

    public $participationGroups;

    public $totalPurchaseValueEurosCents;

    public $totalCurrentValueEurosCents;
    public $formattedTotalCurrentValueEuros;

    public $secondLastTotalValueEurosCents;

    public $diffValueEuroCents;
    public $formattedDiffValueEuros;

    public $_24hAchievedReturn;
    public $_24hFormattedAchievedReturn;

    public $achievedReturn;
    public $formattedAchievedReturn;

    public $factsheets = Array();

    /**
     * @param \App\Models\Fund $fund
     * @param \App\Dtos\ParticipationGroup[] $participationGroups
     */
    public function __construct(ModelsFund $fund, array $participationGroups)
    {
        $currencyFormatter = App::make(CurrencyFormatter::class);
        $returnCalculator = App::make(ReturnCalculator::class);

        $this->slug = $fund->slug;
        $this->name = $fund->name;
        $this->model = $fund;
        $this->participationGroups = $participationGroups;

        $this->totalPurchaseValueEurosCents = 0;
        $this->totalCurrentValueEurosCents = 0;
        $this->secondLastTotalValueEurosCents = 0;
        $this->diffValueEuroCents = 0;
        foreach($this->participationGroups as $participationGroup)
        {
            $this->totalPurchaseValueEurosCents += $participationGroup->totalPurchaseValueEurosCents;
            $this->totalCurrentValueEurosCents += $participationGroup->totalCurrentValueEurosCents;
            $this->secondLastTotalValueEurosCents += $participationGroup->secondLastTotalValueEurosCents;
            $this->diffValueEuroCents += $participationGroup->diffValueEuroCents;
        }

        $this->formattedTotalCurrentValueEuros = $currencyFormatter->formatCurrency($this->totalCurrentValueEurosCents);

        $this->formattedDiffValueEuros = $currencyFormatter->formatDiffCurrencyWithSymbol($this->diffValueEuroCents);

        $this->_24hAchievedReturn = $returnCalculator->calculateReturn($this->secondLastTotalValueEurosCents, $this->totalCurrentValueEurosCents);
        $this->_24hFormattedAchievedReturn = $returnCalculator->format($this->_24hAchievedReturn);

        $this->achievedReturn = $returnCalculator->calculateReturn($this->totalPurchaseValueEurosCents, $this->totalCurrentValueEurosCents);
        $this->formattedAchievedReturn = $returnCalculator->format($this->achievedReturn);

        foreach($fund->factsheets as $factsheet)
        {
            $this->factsheets[] = new Document(
                $factsheet->week,
                route('my_factsheet', ['fund' => $fund->slug, 'year' => $factsheet->year, 'week' => $factsheet->week])
            );
        }
    }
}