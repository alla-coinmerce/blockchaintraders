<?php

namespace App\Services;

use App\Dtos\CoinInvestmentSnapshot;
use App\Dtos\CoinInvestmentsSnapshot;
use App\Exceptions\CoinInfoException;
use App\Exceptions\SnapshotException;
use App\Models\Fund;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CoinInvestmentSnapshotService
{
    public function __construct(
        private CoinInfoService $coinInfoService,
        private DeribitService $deribitService
    ) {}

    public function getSnapshot(Fund $fund, ?Carbon $sampleDateTime)
    {
        $sampleDateTime = $sampleDateTime ? $sampleDateTime : Carbon::now();

        try
        {
            $coinInvestmentSnapshots = [];

            // Get the Deribit investments
            $this->getDeribitCoinInvestments($fund, $sampleDateTime, $coinInvestmentSnapshots);

            // Get all the coin investments
            foreach($fund->coinInvestments as $coinInvestment)
            {
                $coinInvestmentSnapshots[] = new CoinInvestmentSnapshot(
                    $coinInvestment->coin_id,
                    $coinInvestment->coin_name,
                    $coinInvestment->qty,
                    $sampleDateTime,
                    $this->coinInfoService->getCoin($coinInvestment->coin_id)->valueInEuroMilliCents()
                );
            }

            // Create the snapshot of the coin investments
            return new CoinInvestmentsSnapshot($coinInvestmentSnapshots, $sampleDateTime);
        }
        catch(CoinInfoException $e)
        {
            Log::error('Failed to get new coin investments snapshot');

            throw new SnapshotException('Failed to get new coin investments snapshot');
        }
    }

    public function getSnapshotWithNewCoin(Fund $fund, string $coinId, float $qty, ?Carbon $sampleDateTime)
    {
        $sampleDateTime = $sampleDateTime ? $sampleDateTime : Carbon::now();

        try
        {
            $coinInvestmentSnapshots = [];

            // Get the Deribit investments
            $this->getDeribitCoinInvestments($fund, $sampleDateTime, $coinInvestmentSnapshots);
            
            // Get all the coin investments
            foreach($fund->coinInvestments as $coinInvestment)
            {
                $coinInvestmentSnapshots[] = new CoinInvestmentSnapshot(
                    $coinInvestment->coin_id,
                    $coinInvestment->coin_name,
                    $coinInvestment->qty,
                    $sampleDateTime,
                    $this->coinInfoService->getCoin($coinInvestment->coin_id)->valueInEuroMilliCents()
                );
            }

            // Get the value for the new investment
            $newCoin = $this->coinInfoService->getCoin($coinId);

            $coinInvestmentSnapshots[] = new CoinInvestmentSnapshot(
                $coinId,
                $newCoin->name(),
                $qty,
                $sampleDateTime,
                $newCoin->valueInEuroMilliCents()
            );

            // Create the snapshot of the coin investments
            return new CoinInvestmentsSnapshot($coinInvestmentSnapshots, $sampleDateTime);
        }
        catch(CoinInfoException $e)
        {
            Log::error('Failed to get new coin investments snapshot with new coin');

            throw new SnapshotException('Failed to get new coin investments snapshot with new coin');
        }
    }

    public function getSnapshotWithUpdatedCoin(Fund $fund, int $coinInvestmentId, float $newQty, ?Carbon $sampleDateTime)
    {
        $sampleDateTime = $sampleDateTime ? $sampleDateTime : Carbon::now();

        try
        {
            $coinInvestmentSnapshots = [];

            // Get the Deribit investments
            $this->getDeribitCoinInvestments($fund, $sampleDateTime, $coinInvestmentSnapshots);

            // Get all the coin investments
            foreach($fund->coinInvestments as $coinInvestment)
            {
                $qty = $coinInvestment->id === $coinInvestmentId ? $newQty : $coinInvestment->qty;

                $coinInvestmentSnapshots[] = new CoinInvestmentSnapshot(
                    $coinInvestment->coin_id,
                    $coinInvestment->coin_name,
                    $qty,
                    $sampleDateTime,
                    $this->coinInfoService->getCoin($coinInvestment->coin_id)->valueInEuroMilliCents()
                );
            }

            // Create the snapshot of the coin investments
            return new CoinInvestmentsSnapshot($coinInvestmentSnapshots, $sampleDateTime);
        }
        catch(CoinInfoException $e)
        {
            Log::error('Failed to get new coin investments snapshot with new coin');

            throw new SnapshotException('Failed to get new coin investments snapshot with new coin');
        }
    }

    private function getDeribitCoinInvestments($fund, $sampleDateTime, &$coinInvestmentSnapshots)
    {
        if($fund->deribitConnection)
        {
            Log::debug('Adding coins from Deribit to snapshot');
            
            $coinInvestmentSnapshots[] = new CoinInvestmentSnapshot(
                'bitcoin',
                'Bitcoin',
                $this->deribitService->getBitcoinQty(),
                $sampleDateTime,
                $this->coinInfoService->getCoin('bitcoin')->valueInEuroMilliCents(), 
                'Deribit'
            );
            $coinInvestmentSnapshots[] = new CoinInvestmentSnapshot(
                'ethereum',
                'Ethereum',
                $this->deribitService->getEthereumQty(),
                $sampleDateTime,
                $this->coinInfoService->getCoin('ethereum')->valueInEuroMilliCents(), 
                'Deribit'
            );
            $coinInvestmentSnapshots[] = new CoinInvestmentSnapshot(
                'usdc',
                'USDC',
                $this->deribitService->getUsdcQty(),
                $sampleDateTime,
                $this->coinInfoService->getCoin('usd-coin')->valueInEuroMilliCents(), 
                'Deribit'
            );
        }
    }
}