<?php

namespace App\Contracts;

use App\Dtos\Coin;

interface CoinRepository
{

    /**
     * @return Array An array of coinId coinName pairs 
     * 
     * @throws \Exceptions\CoinRepositoryException
     */
    public function getAvaiableCoinsList(): Array;

    /**
     * @param Array $coinIds
     * @return \App\Dtos\Coin[]
     * 
     * @throws \Exceptions\CoinRepositoryException
     */
    public function getCoinInfoForCoinIds(Array $coinIds): Array;

    /**
     * @param string $coinId
     * @return \App\Dtos\Coin
     * 
     * @throws \Exceptions\CoinRepositoryException
     */
    public function getCoinInfoForCoinId(string $coinId): Coin;
}