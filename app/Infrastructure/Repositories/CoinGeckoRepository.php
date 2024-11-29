<?php

namespace App\Infrastructure\Repositories;

use App\Contracts\CoinRepository;
use App\Dtos\Coin;
use App\Exceptions\CoinGeckoException;
use App\Exceptions\CoinRepositoryException;
use App\Infrastructure\Apis\CoinGeckoApi;
use Illuminate\Support\Carbon;

class CoinGeckoRepository implements CoinRepository
{
    public function __construct(
        private CoinGeckoApi $coinGeckoApi
    ) {}

    /**
     * @return Array An array of coin id and name pairs 
     * 
     * @throws \Exceptions\CoinRepositoryException
     */
    public function getAvaiableCoinsList(): Array
    {
        try
        {
            $coinsListJson = $this->coinGeckoApi->getCoinsList();

            // $coinsListJson = json_decode($coinsListJson);
            // $coinsListJson = json_encode($coinsListJson, JSON_PRETTY_PRINT);
            // Log::debug($coinsListJson);

            $coinsArray = [];

            foreach($coinsListJson as $rawCoin)
            {
                $coinsArray[$rawCoin['id']] = $rawCoin['name'];
            }

            return $coinsArray;
        }
        catch(CoinGeckoException $e)
        {
            report($e);

            throw new CoinRepositoryException('Failed to get available coins list.');
        }
    }

    /**
     * @param Array $coinIds
     * @return \App\Dtos\Coin[]
     * 
     * @throws \Exceptions\CoinRepositoryException
     */
    public function getCoinInfoForCoinIds(Array $coinIds): Array
    {
        $coins = [];

        try
        {
            $coinInfoJsonArray = $this->coinGeckoApi->getCurrentCoinsData($coinIds);

            foreach($coinInfoJsonArray as $coinInfoJson)
            {
                $coins[] = $this->coinFromJson($coinInfoJson);
            }
        }
        catch(CoinGeckoException $e)
        {
            report($e);

            throw new CoinRepositoryException('Failed to get coin info for coins list');
        }

        return $coins;
    }

    /**
     * @param string $coinId
     * @return \App\Dtos\Coin
     * 
     * @throws \Exceptions\CoinRepositoryException
     */
    public function getCoinInfoForCoinId(string $coinId): Coin
    {
        try
        {
            $coinInfoJson = $this->coinGeckoApi->getCurrentCoinData($coinId);

            return $this->coinFromJson($coinInfoJson);
        }
        catch(CoinGeckoException $e)
        {
            report($e);

            throw new CoinRepositoryException('Failed to get coin info for coin id '.$coinId);
        }
    }

    private function coinFromJson($coinInfoJson)
    {
        if(!array_key_exists('id', $coinInfoJson))
        {
            throw new CoinRepositoryException('Coin data is missing field: [id]');
        }

        $coinId = $coinInfoJson['id'];

        if(!array_key_exists('name', $coinInfoJson))
        {
            throw new CoinRepositoryException('Coin data for coin '.$coinId.' is missing data for field: [name]');
        }

        if(!array_key_exists('market_data', $coinInfoJson))
        {
            throw new CoinRepositoryException('Coin data for coin '.$coinId.' is missing data for field: [market_data]');
        }

        if(!array_key_exists('current_price', $coinInfoJson['market_data']))
        {
            throw new CoinRepositoryException('Coin data for coin '.$coinId.' is missing data for field: [market_data][current_price]');
        }

        if(!array_key_exists('eur', $coinInfoJson['market_data']['current_price']))
        {
            throw new CoinRepositoryException('Coin data for coin '.$coinId.' is missing data for field: [market_data][current_price][eur]');
        }

        return new Coin(
            $coinId,
            $coinInfoJson['name'],
            $coinInfoJson['market_data']['current_price']['eur'] * 100000, // To millicents
            Carbon::now()
        );
    }
}