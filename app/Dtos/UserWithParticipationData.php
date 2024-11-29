<?php

namespace App\Dtos;

use App\Models\User;
use App\Services\CurrencyFormatter;
use App\Services\ReturnCalculator;
use Illuminate\Support\Facades\App;

class UserWithParticipationData
{
    public $firstname;
    public $email;
    public $funds;

    public $totalPurchaseValueEurosCents;

    public $totalCurrentValueEurosCents;
    public $formattedTotalCurrentValueEuros;

    public $diffValueEuroCents;
    public $formattedDiffValueEuros;

    public $secondLastTotalValueEurosCents;

    public $_24hAchievedReturn;
    public $_24hFormattedAchievedReturn;

    public $achievedReturn;
    public $formattedAchievedReturn;

    public $annualFinancialOverviews = Array();

    /**
     * @param \App\Models\User $user
     * @param \App\Dtos\Fund[] $funds
     */
    public function __construct(User $user, array $funds)
    {
        $currencyFormatter = App::make(CurrencyFormatter::class);
        $returnCalculator = App::make(ReturnCalculator::class);

        $this->firstname = $user->firstname;
        $this->email = $user->email;
        $this->funds = $funds;

        $this->totalPurchaseValueEurosCents = 0;
        $this->totalCurrentValueEurosCents = 0;
        $this->secondLastTotalValueEurosCents = 0;
        $this->diffValueEuroCents = 0;
        foreach($this->funds as $fund)
        {
            $this->totalPurchaseValueEurosCents += $fund->totalPurchaseValueEurosCents;
            $this->totalCurrentValueEurosCents += $fund->totalCurrentValueEurosCents;
            $this->secondLastTotalValueEurosCents += $fund->secondLastTotalValueEurosCents;
            $this->diffValueEuroCents += $fund->diffValueEuroCents;
        }

        $this->formattedTotalCurrentValueEuros = $currencyFormatter->formatCurrency($this->totalCurrentValueEurosCents);

        $this->formattedDiffValueEuros = $currencyFormatter->formatDiffCurrencyWithSymbol($this->diffValueEuroCents);

        $this->_24hAchievedReturn = $returnCalculator->calculateReturn($this->secondLastTotalValueEurosCents, $this->totalCurrentValueEurosCents);
        $this->_24hFormattedAchievedReturn = $returnCalculator->format($this->_24hAchievedReturn);

        $this->achievedReturn = $returnCalculator->calculateReturn($this->totalPurchaseValueEurosCents, $this->totalCurrentValueEurosCents);
        $this->formattedAchievedReturn = $returnCalculator->format($this->achievedReturn);

        foreach($user->annualFinancialOverviews as $annualFinancialOverview)
        {
            $this->annualFinancialOverviews[] = new Document(
                $annualFinancialOverview->original_file_name,
                route('persoonlijkdocument', ['id' => $annualFinancialOverview->id, 'name' => $annualFinancialOverview->original_file_name])
            );
        }
    }
}