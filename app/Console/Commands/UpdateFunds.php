<?php

namespace App\Console\Commands;

use App\Enums\Role;
use App\Infrastructure\Repositories\FundSnapshotRepository;
use App\Models\Fund;
use App\Models\User;
use App\Notifications\FundAutoUpdateFailedNotification;
use App\Services\CoinInfoService;
use App\Services\FundSnapshotService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Throwable;

class UpdateFunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-funds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'If automatic updating for a fund is enabled update the fund value.';

    /**
     * Execute the console command.
     */
    public function handle(CoinInfoService $coinInfoService, FundSnapshotService $fundSnapshotService, FundSnapshotRepository $fundSnapshotRepository)
    {
        $sampleDateTime = Carbon::now();
        $europeAmsterdamTime = $sampleDateTime->copy()->setTimezone('Europe/Amsterdam');
        
        Log::debug('Auto updating funds: '.$sampleDateTime.' [UTC], '.$europeAmsterdamTime.' [Europe/Amsterdam]');

        try
        {
            $coinInfoService->refreshCoinInfoCache();

            foreach(Fund::all() as $fund)
            {
                if($fund->auto_update_enabled)
                {
                    $fundSnapshot = $fundSnapshotService->getSnapshot($fund, $sampleDateTime);
    
                    $fundSnapshotRepository->persistSnapshot($fund, $fundSnapshot);
                }
            }
        }
        catch(Throwable $t)
        {
            report($t);

            $admins = User::where('role', Role::ADMIN->value)
                ->get();

            foreach($admins as $admin)
            {
                $admin->notify(new FundAutoUpdateFailedNotification());
            }
        }        
    }
}
