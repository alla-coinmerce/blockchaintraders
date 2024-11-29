<?php

namespace App\Services;

use App\Models\CoinInvestment;

class CoinInvestmentService
{
    /**
     * @return []
     */
    public function getUniqueCoinIds(): Array
    {
        $coinIds = [];
        $uniqueCoinInvestments = CoinInvestment::select('coin_id')->distinct()->get();

        foreach($uniqueCoinInvestments as $uniqueCoinInvestment)
        {
            $coinIds[] = $uniqueCoinInvestment->coin_id;
        }

        return $coinIds;
    }
}