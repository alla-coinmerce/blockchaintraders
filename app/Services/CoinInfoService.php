<?php

namespace App\Services;

use App\Contracts\CoinRepository;
use App\Exceptions\CoinInfoException;
use App\Exceptions\CoinRepositoryException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CoinInfoService
{
    // Cache 16 hours = 16 * 3600 = 57.600 seconds
    private const COIN_TTL = 57600;

    public function __construct(
        private CoinInvestmentService $coinInvestmentService,
        private CoinRepository $coinRepository
    ) {}

    public function refreshCoinInfoCache()
    {
        Log::debug('Start coin cache update');

        // Generate a single list of coins to avoid unnecessary API calls when multiple funds invest in the same coin.
        $coinIds = $this->coinInvestmentService->getUniqueCoinIds();

        try
        {
            $coins = $this->coinRepository->getCoinInfoForCoinIds($coinIds);

            foreach($coins as $coin)
            {
                Log::debug('Updating cache for coin '.$coin->id().'. New value in euros: '.$coin->formattedCoinValueInEuros());
            
                Cache::put('coinInfo_'.$coin->id(), $coin, self::COIN_TTL);
            }
        }
        catch(CoinRepositoryException $e)
        {
            report($e);
            
            Log::error('Failed to refresh coin info cache');

            throw new CoinInfoException('Failed to refresh coin info cache');
        }

        Log::debug('Coin cache updated');
    }

    /**
     * @param string $searchString
     * @return Array An array of coinId coinName pairs 
     */
    public function findCoinsThatContain($searchString, $maxResults = 10000): Array
    {
        $matches = [];

        try
        {
            $coinsList = Cache::remember('coinsList', 3600, function() {
                return $this->coinRepository->getAvaiableCoinsList();
            });
    
            $i = 0;
            foreach($coinsList as $id => $name)
            {
                if(str_contains(strtolower($name), strtolower($searchString)))
                {
                    $i++;
                    $matches[$id] =$name;
                }
               
                if($i >= $maxResults)
                {
                    break;
                }
            }
        }
        catch(CoinRepositoryException $e)
        {
            report($e);

            Log::error('Failed to fetch coins list.');
        }

        return $matches;
    }

    /**
     * @param string $coinId
     * @return \App\Dtos\Coin
     * 
     * @throws \Exceptions\CoinInfoException
     */
    public function getCoin($coinId)
    {
        try
        {
            return Cache::remember('coinInfo_'.$coinId, self::COIN_TTL, function() use ($coinId) {
                return $this->coinRepository->getCoinInfoForCoinId($coinId);
            });
        }
        catch(CoinRepositoryException $e)
        {
            report($e);

            Log::error('Failed to fetch coin from repository');

            throw new CoinInfoException('Failed to fetch coin from repository');
        }
    }
}