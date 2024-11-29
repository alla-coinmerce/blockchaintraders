<?php

namespace App\Infrastructure\Repositories;

use App\Dtos\FundSnapshot;
use App\Models\Fund;

class FundSnapshotRepository
{
    public function persistSnapshot(Fund $fund, FundSnapshot $fundSnapshot)
    {
        $fundValue = $fund->fundValues()->create([
            'value_eurocents' => $fundSnapshot->fundValueInEuroCents(),
            'value_dollarcents' => null,
            'date_time' => $fundSnapshot->sampleDateTime(),
            'date' => $fundSnapshot->sampleDateTime()->format('Y-m-d'),
            'time' => $fundSnapshot->sampleDateTime()->format('H:i:s')
        ]);

        //     $numberOfParticipations = $fund->participations()->excludingDemoAccounts()->sum('qty');
        $fundValue->numberOfParticipationsSample()->create([
            'sample_taken_at' => $fundSnapshot->sampleDateTime(),
            'fund_id' => $fund->id,
            'number_of_participations' => $fundSnapshot->numberOfParticipations()
        ]);

        $particiaptionInvestmentSamplesData = [];
        foreach($fundSnapshot->participationInvestmentsSnapshot()->participationInvestmentSnapshots() as $participationInvestmentSnapshot)
        {
            $particiaptionInvestmentSamplesData[] = [
                'sample_taken_at' => $fundSnapshot->sampleDateTime(),
                'value_eurocents' => $participationInvestmentSnapshot->participationValueInEuroCents(),
                'number_of_participations' => $participationInvestmentSnapshot->qty(),
                'sample_source_id' => $participationInvestmentSnapshot->sampleSourceFundId()
            ];
        }

        // Save the participation investment samples
        $fundValue->participationInvestmentSamples()->createMany($particiaptionInvestmentSamplesData);

        $coinInvestmentSamplesData = [];
        foreach($fundSnapshot->coinInvestmentsSnapshot()->coinInvestmentSnapshots() as $coinInvestmentSnapshot)
        {
            $coinInvestmentSamplesData[] = [
                'coin_id' => $coinInvestmentSnapshot->coinId(),
                'coin_name' => $coinInvestmentSnapshot->coinName(),
                'sample_taken_at' => $fundSnapshot->sampleDateTime(),
                'value_eurocents' => $coinInvestmentSnapshot->coinValueInEuroMilliCents() / 1000,
                'value_euro_millicents' => $coinInvestmentSnapshot->coinValueInEuroMilliCents(),
                'qty' => $coinInvestmentSnapshot->qty()
            ];
        }

        // Save the coin investment samples
        $fundValue->coinInvestmentSamples()->createMany($coinInvestmentSamplesData);
    }
}