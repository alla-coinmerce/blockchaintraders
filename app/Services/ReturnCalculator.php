<?php

namespace App\Services;

class ReturnCalculator
{
    /**
     * Calculates the achieved return for a given start and endvalue
     * 
     * @param int $startvalue
     * @param int $endValue
     * @return float percentage
     */
    public function calculateReturn($startvalue, $endValue): float
    {
        // Prevent division by zero
        if($startvalue === 0)
        {
            return 0;
        }

        return (($endValue - $startvalue) / $startvalue) * 100;
    }

    /**
     * Format a return with 2 decimals precision
     * 
     * @param float $percentage
     * @return string percentage
     */
    public function format($percentage)
    {
        $formatted = number_format($percentage, 2, ',', '.');

        if(! ($percentage < 0))
        {
            $formatted = '+'.$formatted;
        }

        return $formatted;
    }
}