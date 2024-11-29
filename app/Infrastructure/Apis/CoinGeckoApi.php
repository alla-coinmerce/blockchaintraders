<?php

namespace App\Infrastructure\Apis;

use App\Exceptions\CoinGeckoException;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class CoinGeckoApi
{
    private const ROOT_URL = "https://pro-api.coingecko.com/api/v3/";

    /**
     * List of all supported coins id, name and symbol.
     */
    public function getCoinsList()
    {
        return $this->getCoinGeckoResponseJson("coins/list");
    }

    /**
     * Get current data (name, price, market, ... including exchange tickers) for a list of coins.
     */
    public function getCurrentCoinsData(Array $coinIds)
    {
        Log::debug('Making API calls');

        $jsonArray = [];
        
        try
        {
            $responses = Http::pool(function (Pool $pool) use ($coinIds) {
                $apiKey = config('coin_gecko.api_key');

                if(!$apiKey)
                {
                    throw new CoinGeckoException("CoinGecko API KEY NOT SET.");
                }

                foreach($coinIds as $coinId)
                {
                    $pool->as($coinId)->acceptJson()->connectTimeout(30)->retry(5, 200)->get(self::ROOT_URL."coins/".$coinId."?x_cg_pro_api_key=".$apiKey);
                    
                    // Add a little delay to comply with 500 / min rate limit
                    usleep(120000);
                }
            });

            foreach($responses as $key => $response)
            {
                if(is_a($response, \GuzzleHttp\Exception\ConnectException::class))
                {
                    Log::warning("Guzzle ConnectException: ".$response->getMessage());
                    Log::warning("Guzzle ConnectException: ".$response->getTraceAsString());

                    throw new CoinGeckoException("Guzzle ConnectException: ".$response->getMessage());
                }
                elseif(is_a($response, \GuzzleHttp\Exception\RequestException ::class))
                {
                    Log::warning("Guzzle RequestException: ".$response->getMessage());
                    Log::warning("Guzzle RequestException: ".$response->getTraceAsString());

                    throw new CoinGeckoException("Guzzle RequestException: ".$response->getMessage());
                }

                if(!$response->ok())
                {
                    Log::error('CoinGecko response not ok: '.$response->status());
                    Log::info('Coin '.$key.' returned '.$response->body());
        
                    throw new CoinGeckoException("Response not OK: ".$response->status());
                }    

                $jsonArray[] = $response->json();
            }
        }
        catch(Throwable $t)
        {
            report($t);

            throw new CoinGeckoException("CoinGecko API call failed.");
        }

        return $jsonArray;
    }

    /**
     * Get current data (name, price, market, ... including exchange tickers) for a coin.
     */
    public function getCurrentCoinData(string $coinId)
    {
        return $this->getCoinGeckoResponseJson("coins/".$coinId);
    }

    private function getCoinGeckoResponseJson(string $endpoint)
    {
        Log::debug('Making API call');

        $response = null;

        $apiKey = config('coin_gecko.api_key');

        if(!$apiKey)
        {
            throw new CoinGeckoException("CoinGecko API KEY NOT SET.");
        }

        $url = self::ROOT_URL.$endpoint."?x_cg_pro_api_key=".$apiKey;

        try
        {
            $response = Http::acceptJson()->get($url);
        }
        catch(Throwable $t)
        {
            report($t);

            throw new CoinGeckoException("CoinGecko API call failed.");
        }

        // Check if we hit the API rate limit
        if($response->failed() && $response->status() == 429)
        {
            $secondsRemaining = $response->header('Retry-After');

            Log::debug('Limit reached retrying after '.$secondsRemaining.' seconds');

            sleep((int)$secondsRemaining);

            Log::debug('Retry making API call');
            
            $response = Http::retry(5, 200)->acceptJson()->get(self::ROOT_URL.$endpoint);
        }

        if(!$response->ok())
        {
            Log::error('CoinGecko response not ok: '.$response->status());

            throw new CoinGeckoException("Response not OK: ".$response->status());
        }

        return $response->json();
    }
}