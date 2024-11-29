<?php

namespace App\Services;

use App\Contracts\FundSnapshotExportService;
use App\Models\Fund;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FundSnapshotCsvExportService implements FundSnapshotExportService
{
    public function __construct(
        private CoinInvestmentService $coinInvestmentService
    ) {}

    /**
     * @param \App\Models\Fund $fund
     * @param string $startDate
     * @param string $endDate
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportSnapshotsForFund(Fund $fund, string $startDate, string $endDate): StreamedResponse
    {
        $rows = [];
        $coinNames = [];
        $fundNames = [];
    
        $fundValues = $fund->fundValues
                        ->when(!empty($startDate), function (Collection $collection) use ($startDate) {
                            return $collection->where('date', '>=', $startDate);
                        })
                        ->when(!empty($endDate), function (Collection $collection) use ($endDate) {
                            return $collection->where('date', '<=', $endDate);
                        });

        // Foreach FundValue build export array
        // Get all the FundValues with relations (CoinInvestmentSamples, ParticipationInvestmentSamples and NumberOfParticipations)
        foreach($fundValues as $fundValue)
        {
            $row = [
                'Date' => $fundValue->date,
                'Time (GMT)' => $fundValue->timeUtc,
                'Time (Europe/Amsterdam)' => $fundValue->timeEuropeAmsterdam,
                'Fund value' => $fundValue->displayValueEuros,
                'Participtions Qty' => $fundValue->numberOfParticipationsSample ? $fundValue->numberOfParticipationsSample->number_of_participations : '',
                'Total Invested Value' => 0,
                'Coins Investments total' => 0,
                'Particiption Investments total' => 0,
                'CoinInvestments' => [],
                'ParticipationInvestments' => []
            ];

            foreach($fundValue->coinInvestmentSamples as $coinInvestmentSample)
            {
                $qty = array_key_exists($coinInvestmentSample->coin_id, $row['CoinInvestments']) ? 
                            $row['CoinInvestments'][$coinInvestmentSample->coin_id]['Qty'] + $coinInvestmentSample->qty : 
                            $coinInvestmentSample->qty;

                $total = array_key_exists($coinInvestmentSample->coin_id, $row['CoinInvestments']) ? 
                            $row['CoinInvestments'][$coinInvestmentSample->coin_id]['Total'] + ($coinInvestmentSample->value_euro_millicents * $coinInvestmentSample->qty) : 
                            $coinInvestmentSample->value_euro_millicents * $coinInvestmentSample->qty;

                $row['CoinInvestments'][$coinInvestmentSample->coin_id] = [
                    'Coin name' => $coinInvestmentSample->coin_name,
                    'Qty' => $qty,
                    'Value' => $coinInvestmentSample->displayValueEuros,
                    'Total' => $total
                ];

                $row['Coins Investments total'] += $coinInvestmentSample->value_euro_millicents * $coinInvestmentSample->qty;

                $coinNames[] = $coinInvestmentSample->coin_name;
            }

            foreach($fundValue->participationInvestmentSamples as $participationInvestmentSample)
            {
                $qty = array_key_exists($participationInvestmentSample->investedInFund->name, $row['ParticipationInvestments']) ? 
                            $row['ParticipationInvestments'][$participationInvestmentSample->investedInFund->name]['Qty'] + $participationInvestmentSample->number_of_participations : 
                            $participationInvestmentSample->number_of_participations;

                $total = array_key_exists($participationInvestmentSample->investedInFund->name, $row['ParticipationInvestments']) ? 
                            $row['ParticipationInvestments'][$participationInvestmentSample->investedInFund->name]['Total'] + ($participationInvestmentSample->value_eurocents * $participationInvestmentSample->number_of_participations) : 
                            $participationInvestmentSample->value_eurocents * $participationInvestmentSample->number_of_participations;

                $row['ParticipationInvestments'][$participationInvestmentSample->investedInFund->name] = [
                    'Fund name' => $participationInvestmentSample->investedInFund->name,
                    'Qty' => $qty,
                    'Value' => $participationInvestmentSample->displayValueEuros,
                    'Total' => $total
                ];

                $row['Particiption Investments total'] += $participationInvestmentSample->value_eurocents * $participationInvestmentSample->number_of_participations;

                $fundNames[] = $participationInvestmentSample->investedInFund->name;
            }

            // Convert millicents to cents
            $row['Coins Investments total'] = $row['Coins Investments total'] / 1000;

            // Sum
            $row['Total Invested Value'] = $row['Coins Investments total'] + $row['Particiption Investments total'];

            // Format
            $row['Particiption Investments total'] = $this->formattedValue($row['Particiption Investments total']);
            $row['Coins Investments total'] = $this->formattedValue($row['Coins Investments total']);
            $row['Total Invested Value'] = $this->formattedValue($row['Total Invested Value']);

            $rows[] = $row;
        }

        // Create a list of sorted unique coin names
        $coinNames = array_unique($coinNames);
        sort($coinNames);

        // Create a list of sorted unique fund names
        $fundNames = array_unique($fundNames);
        sort($fundNames);

        // Create the header
        $header = [
            'Date',
            'Time (GMT)',
            'Time (Europe/Amsterdam)',
            'Fund value',
            'Participtions Qty',
            'Total Invested Value',
            'Coins Investments total',
            'Particiption Investments total'
        ];

        foreach($coinNames as $coinName)
        {
            $header[] = $coinName.'[Qty]';
            $header[] = $coinName.'[Value]';
            $header[] = $coinName.'[Total]';
        }
        
        foreach($fundNames as $fundName)
        {
            $header[] = $fundName.'[Qty]';
            $header[] = $fundName.'[Value]';
            $header[] = $fundName.'[Total]';
        }

        $table = [
            $header
        ];

        foreach($rows as $row)
        {
            $data = [
                $row['Date'],
                $row['Time (GMT)'],
                $row['Time (Europe/Amsterdam)'],
                $row['Fund value'],
                $row['Participtions Qty'],
                $row['Total Invested Value'],
                $row['Coins Investments total'],
                $row['Particiption Investments total']
            ];

            foreach($coinNames as $coinName)
            {
                $qty = '';
                $value = '';
                $total = '';
                
                foreach($row['CoinInvestments'] as $coinInvestment)
                {
                    if($coinName === $coinInvestment['Coin name'])
                    {
                        $qty = $coinInvestment['Qty'];
                        $value = $coinInvestment['Value'];
                        $total = $this->formattedValue($coinInvestment['Total']);

                        break;
                    }
                }
                
                $data[] = $qty;
                $data[] = $value;
                $data[] = $total;
            }

            foreach($fundNames as $fundName)
            {
                $qty = '';
                $value = '';
                $total = '';
                
                foreach($row['ParticipationInvestments'] as $participationInvestment)
                {
                    if($fundName === $participationInvestment['Fund name'])
                    {
                        $qty = $participationInvestment['Qty'];
                        $value = $participationInvestment['Value'];
                        $total = $this->formattedValue($participationInvestment['Total']);

                        break;
                    }
                }
                
                $data[] = $qty;
                $data[] = $value;
                $data[] = $total;
            }

            $table[] = $data;
        }
        
        // Log::debug($table);

        // Export to csv
        return response()->streamDownload(function () use ($table) {
            foreach($table as $row)
            {
                echo "\"".implode('","',array_values($row))."\"\n";
            }
        },
        Carbon::now()->format('Y-m-d').'_'.$fund->name.'_export.csv',
        [
            // Set the content type to CSV
            'Content-Type' =>'text/csv; charset=utf-8',
            // Set the response header to specify that the file should be downloaded as an attachment
            'Content-Disposition' => 'attachment; filename=data.csv'
        ],
        'attachment');
    }

    private function formattedValue($cents, $symbol="€")
    {
        if(null === $cents)
        {
            return '';
        }

        return $symbol.number_format($cents / 100, 2, ',', '.');
    }
}