<?php

namespace App\Contracts;

use App\Models\Fund;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FundSnapshotExportService
{
    /**
     * @param \App\Models\Fund $fund
     * @param string $startDate
     * @param string $endDate
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportSnapshotsForFund(Fund $fund, string $startDate, string $endDate): StreamedResponse;
}