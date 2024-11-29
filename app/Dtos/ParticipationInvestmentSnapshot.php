<?php

namespace App\Dtos;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class ParticipationInvestmentSnapshot
{
    private CurrencyFormatter $currencyFormatter;

    public function __construct(
        private string $sampleSourceFundId,
        private string $fundName,
        private string $purchaseDate,
        private string $qty,
        private Carbon $sampleDateTime,
        private int $participationValueInEuroCents
    )
    {
        $this->currencyFormatter = App::make(CurrencyFormatter::class);
    }

    public function sampleSourceFundId() { return $this->sampleSourceFundId; }

    public function fundName() { return $this->fundName; }

    public function purchaseDate() { return $this->purchaseDate; }

    public function qty() { return $this->qty; }

    public function sampleDateTime() { return $this->sampleDateTime; }

    public function participationValueInEuroCents() { return $this->participationValueInEuroCents; }

    public function formattedParticipationValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrency($this->participationValueInEuroCents);
    }

    public function investmentValueInEuroCents() { return $this->participationValueInEuroCents * $this->qty; }

    public function formattedInvestmentValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrency($this->investmentValueInEuroCents());
    }
}