<?php

namespace App\Console\Commands;

use App\Services\CoinInfoService;
use Illuminate\Console\Command;

class RefreshCoinInfoCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-coin-info-cache-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Triggers a refresh of the coin info cache';

    /**
     * Execute the console command.
     */
    public function handle(CoinInfoService $coinInfoService)
    {
        $coinInfoService->refreshCoinInfoCache();
    }
}
