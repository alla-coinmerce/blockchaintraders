<?php

namespace App\Services;

class CurrencyFormatter
{
    /**
     * Format a currency in cents with thousands seperated by . and decimals seperated by a , 
     * 
     * @param int $cents
     * @return string
     */
    public function formatCurrency(int $cents): string
    {
        return ($cents !== null) ? number_format($cents / 100, 2, ',', '.') : '';
    }

    /**
     * Format a currency in cents with thousands seperated by . and decimals seperated by a , and prefix
     * with + or - and currency symbol
     * 
     * @param int $cents
     * @param string $symbol (optional)
     * @return string
     */
    public function formatDiffCurrencyWithSymbol(int $cents, string $symbol='€'): string
    {
        if($cents == null)
        {
            return '';
        }

        $formatted = $cents < 0 ? '- ' : '+ ';
        $formatted .= $symbol;

        $cents = $cents < 0 ? 0 - $cents : $cents;

        return $formatted.$this->formatCurrency($cents);
    }

    /**
     * Format a currency in millicents with thousands seperated by . and decimals seperated by a , and prefix
     * with + or - and currency symbol
     * 
     * @param int $cents
     * @param string $symbol (optional)
     * @return string
     */
    public function formatCurrencyHighPrecion(float $millicents): string
    {
        return ($millicents !== null) ? number_format($millicents / 100000, 4, ',', '.') : '';
    }
}