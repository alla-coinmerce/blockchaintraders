<?php

namespace App\Services;

use App\Dtos\ParticipationInvestmentSnapshot;
use App\Dtos\ParticipationInvestmentsSnapshot;
use App\Exceptions\SnapshotException;
use App\Models\Fund;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ParticipationInvestmentSnapshotService
{
    public function __construct(
        
    ) {}

    public function getSnapshot(FundSnapshotService $fundSnapshotService, Fund $fund, ?Carbon $sampleDateTime)
    {
        $sampleDateTime = $sampleDateTime ? $sampleDateTime : Carbon::now();

        try
        {
            // Get all the particiaption investments
            $participationInvestmentSnapshots = [];
            foreach($fund->participationInvestments as $particiaption)
            {
                $participationValueInEuroCents = 0;

                if($particiaption->fund->auto_update_enabled)
                {
                    Log::debug('Creating Participation Investment Snapshot based on fund investments');

                    $fundSnapshot = $fundSnapshotService->getSnapshot($particiaption->fund, $sampleDateTime);

                    $participationValueInEuroCents = $fundSnapshot->fundValueInEuroCents();
                }
                else
                {
                    Log::debug('Creating Participation Investment Snapshot using latest available FundValue');

                    // $participationValueInEuroCents = $fund->currentFundValue->value_eurocents;
                    $participationValueInEuroCents = $particiaption->fund->currentFundValue->value_eurocents;
                }
                

                $participationInvestmentSnapshots[] = new ParticipationInvestmentSnapshot(
                    $particiaption->fund_id,
                    $particiaption->fund->name,
                    $particiaption->purchase_date,
                    $particiaption->qty,
                    $sampleDateTime,
                    $participationValueInEuroCents
                );
            }

            // Create the snapshot of the coin investments
            return new ParticipationInvestmentsSnapshot($participationInvestmentSnapshots, $sampleDateTime);
        }
        catch(\Exception $e)
        {
            Log::error('Failed to get new particiaption investments snapshot with new coin');
            Log::error($e->getMessage());

            throw new SnapshotException('Failed to get new particiaption investments snapshot with new coin');
        }
    }
}