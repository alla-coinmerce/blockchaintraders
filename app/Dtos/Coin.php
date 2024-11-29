<?php

namespace App\Dtos;

use App\Services\CurrencyFormatter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class Coin
{
    private CurrencyFormatter $currencyFormatter;

    public function __construct(
        private string $id, 
        private string $name,
        private string $valueInEuroMilliCents,
        private Carbon $sampleDateTime
    )
    {
        $this->currencyFormatter = App::make(CurrencyFormatter::class);
    }

    public function id() { return $this->id; }

    public function name() { return $this->name; }

    public function valueInEuroMilliCents() { return $this->valueInEuroMilliCents; }

    public function formattedCoinValueInEuros()
    {
        return '€'.$this->currencyFormatter->formatCurrencyHighPrecion($this->valueInEuroMilliCents);
    }

    public function sampleDateTime() { return $this->sampleDateTime; }
}