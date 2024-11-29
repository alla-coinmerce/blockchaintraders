<?php

namespace App\Dtos;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class CoinInvestmentSnapshot
{
    private CurrencyFormatter $currencyFormatter;

    public function __construct(
        private string $coinId,
        private string $coinName,
        private string $qty,
        private Carbon $sampleDateTime,
        private int $coinValueInEuroMilliCents,
        private string $origin = ''
    )
    {
        $this->currencyFormatter = App::make(CurrencyFormatter::class);
    }

    public function coinId() { return $this->coinId; }

    public function coinName() { return $this->coinName; }

    public function qty() { return $this->qty; }

    public function sampleDateTime() { return $this->sampleDateTime; }

    public function coinValueInEuroMilliCents() { return $this->coinValueInEuroMilliCents; }

    public function formattedCoinValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrencyHighPrecion($this->coinValueInEuroMilliCents);
    }

    public function investmentValueInEuroMilliCents() { return $this->coinValueInEuroMilliCents * $this->qty; }

    public function formattedInvestmentValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrencyHighPrecion($this->investmentValueInEuroMilliCents());
    }

    public function origin() { return $this->origin; }
}