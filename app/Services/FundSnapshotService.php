<?php

namespace App\Services;

use App\Dtos\FundSnapshot;
use App\Models\CoinInvestment;
use App\Models\Fund;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class FundSnapshotService
{
    public function __construct(
        private CoinInvestmentSnapshotService $coinInvestmentSnapshotService,
        private ParticipationInvestmentSnapshotService $particiaptionInvestmentSnapshotService,
    ) {}

    /**
     * 
     */
    public function getSnapshot(Fund $fund, ?Carbon $sampleDateTime = null)
    {
        Log::debug('Taking snapshot for fund '.$fund->name);

        $sampleDateTime = $sampleDateTime ? $sampleDateTime : Carbon::now();

        // Get a snapshot of the coin investments
        $coinInvestmentsSnapshot = $this->coinInvestmentSnapshotService->getSnapshot($fund, $sampleDateTime);

        // Get a snapshot of the participation investments
        $participationSnapshot = $this->particiaptionInvestmentSnapshotService->getSnapshot($this, $fund, $sampleDateTime);

        return new FundSnapshot(
            $coinInvestmentsSnapshot,
            $participationSnapshot,
            $fund->numberOfParticipationsExcludingDemoAccounts(),
            $sampleDateTime
        );
    }

    /**
     * 
     */
    public function getSnapshotWithNewCoin(Fund $fund, string $coinId, float $qty)
    {
        Log::debug('Taking snapshot for fund '.$fund->name.' with new coin ['.$coinId.', '.$qty.']');

        // Get the time of the snapshot
        $sampleDateTime = Carbon::now();

        // Get a snapshot of the coin investments
        $coinInvestmentsSnapshot = $this->coinInvestmentSnapshotService->getSnapshotWithNewCoin($fund, $coinId, $qty, $sampleDateTime);

        // Get a snapshot of the participation investments
        $participationSnapshot = $this->particiaptionInvestmentSnapshotService->getSnapshot($this, $fund, $sampleDateTime);

        return new FundSnapshot(
            $coinInvestmentsSnapshot,
            $participationSnapshot,
            $fund->numberOfParticipationsExcludingDemoAccounts(),
            $sampleDateTime
        );
    }

    /**
     * 
     */
    public function getSnapshotWithUpdatedCoin(Fund $fund, CoinInvestment $coinInvestment, float $qty)
    {
        Log::debug('Taking snapshot for fund '.$fund->name.' with updated coin ['.$coinInvestment->coin_id.', '.$qty.']');

        // Get the time of the snapshot
        $sampleDateTime = Carbon::now();

        // Get a snapshot of the coin investments
        $coinInvestmentsSnapshot = $this->coinInvestmentSnapshotService->getSnapshotWithUpdatedCoin($fund, $coinInvestment->id, $qty, $sampleDateTime);

        // Get a snapshot of the participation investments
        $participationSnapshot = $this->particiaptionInvestmentSnapshotService->getSnapshot($this, $fund, $sampleDateTime);

        return new FundSnapshot(
            $coinInvestmentsSnapshot,
            $participationSnapshot,
            $fund->numberOfParticipationsExcludingDemoAccounts(),
            $sampleDateTime
        );
    }
}