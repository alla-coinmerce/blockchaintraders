<?php

namespace App\Services;

use App\Exceptions\DeribitException;
use App\Infrastructure\Apis\DeribitApi;
use Illuminate\Support\Facades\Log;

class DeribitService
{
    public function __construct(
        private DeribitApi $deribitApiClient
    ) {}

    public function getBitcoinQty()
    {
        return $this->getQtyFor('BTC');   
    }

    public function getEthereumQty()
    {
        return $this->getQtyFor('ETH');
    }

    public function getUsdcQty()
    {
        return $this->getQtyFor('USDC');
    }

    private function getQtyFor($currency)
    {
        $qty = 'Not available';

        try
        {
            $json = $this->deribitApiClient->getAccountSummary($currency);

            if(!array_key_exists('result', $json))
            {
                Log::error("Deribit get account summary response expected result, but got:");
                Log::error($json);

                throw new DeribitException("Deribit get account summary response result missing.");
            }

            $result = $json['result'];

            if(!array_key_exists('equity', $result))
            {
                Log::error("Deribit get account summary response expected result equity, but got:");
                Log::error($json);

                throw new DeribitException("Deribit get account summary response result equity missing.");
            }

            // Log::debug($json);

            $qty = $result['equity'];
        }
        catch(DeribitException $e)
        {
            report($e);
        }
        
        return $qty;
    }
}