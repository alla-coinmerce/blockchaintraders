<?php

namespace App\Infrastructure\Apis;

use App\Exceptions\DeribitException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class DeribitApi
{
    private const ROOT_URL = "https://www.deribit.com/api/v2/";
    private string $token = '';

    /**
     * @param string $currency allowed values ETH, BTC
     */
    public function getAccountSummary($currency)
    {
        $response = null;

        try
        {
            if(empty($this->token))
            {
                $this->authenticate();
            }

            $response = Http::withToken($this->token)->acceptJson()->get(self::ROOT_URL.'private/get_account_summary', [
                'currency' => $currency
            ]);
        }
        catch(Throwable $t)
        {
            Log::error($t->getMessage());

            throw new DeribitException("Deribit get positions api call failed.");
        }

        if(!$response->ok())
        {
            Log::error('Deribit get account summary response expected 200 but got '.$response->status());

            throw new DeribitException("Deribit get account summary response not ok");
        }

        return $response->json();
    }

    private function authenticate()
    {
        $response = null;
        $clientId = config('deribit.client_id');
        $clientSecret = config('deribit.client_secret');

        if(!$clientId || !$clientSecret)
        {
            throw new DeribitException("DERIBIT CLIENT CREDIENTIALS NOT SET.");
        }

        try
        {
            $response = Http::acceptJson()->get(self::ROOT_URL.'public/auth', [
                'grant_type' => 'client_credentials',
                'client_id' => $clientId,
                'client_secret' => $clientSecret
            ]);
        }
        catch(Throwable $t)
        {
            Log::error($t->getMessage());

            throw new DeribitException("Deribit authentication api call failed.");
        }

        if(!$response->ok())
        {
            Log::error('Deribit authenticate response expected 200 but got '.$response->status());

            throw new DeribitException("Deribit authenticate response not ok");
        }

        $json = $response->json();

        if(!array_key_exists('result', $json))
        {
            Log::error("Deribit get positions response expected result, but got:");
            Log::error($json);
            throw new DeribitException("Deribit authentication response result missing.");
        }

        $result = $json['result'];

        if(!array_key_exists('access_token', $result))
        {
            Log::error("Deribit get positions response expected access_token, but got:");
            Log::error($result);

            throw new DeribitException("Deribit authentication response token missing.");
        }

        if(!array_key_exists('token_type', $result))
        {
            Log::error("Deribit get positions response expected token_type, but got:");
            Log::error($result);

            throw new DeribitException("Deribit authentication response token type missing.");
        }

        if($result['token_type'] !== 'bearer')
        {
            throw new DeribitException("Deribit authentication response wrong token type: ".$result['token_type']);
        }

        $this->token = $result['access_token'];
    }
}