<?php

namespace App\Http\Livewire;

use App\Exceptions\CoinInfoException;
use App\Models\CoinInvestment;
use App\Services\CoinInfoService;
use App\Services\CurrencyFormatter;
use App\Services\FundSnapshotService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Throwable;

class CoinSearchAndCreate extends Component
{
    /**
     * @var \App\Models\Fund
     */
    public $fund;

    public $search = '';

    public $coinId = 0;
    public $coinName = '';

    public $qty = 1.00;

    public $formattedCoinValue = '';

    public $testResultsAvailable = false;
    public $testResultHtml = '';

    protected $rules = [
        'qty' => 'required|decimal:0,6',
    ];

    public function selectCoin($coinId, $coinName)
    {
        Log::debug('Selected coin: '.$coinId);

        $this->coinId = $coinId;
        $this->coinName = $coinName;

        $coinInfoService = App::make(CoinInfoService::class);

        try
        {
            $coin = $coinInfoService->getCoin($coinId);

            if($coin)
            {
                $currencyFormatter = App::make(CurrencyFormatter::class);
                $this->formattedCoinValue = '€'.$currencyFormatter->formatCurrencyHighPrecion($coin->valueInEuroMilliCents());
            }
            else
            {
                $this->formattedCoinValue = '';
            }
            
        }
        catch(CoinInfoException $e)
        {
            report($e);

            $this->formattedCoinValue = 'Unknown';
        }

        return $this->formattedCoinValue;
    }

    public function test(FundSnapshotService $fundSnapshotService)
    {
        try
        {
            $fundSnapshot = $fundSnapshotService->getSnapshotWithNewCoin($this->fund, $this->coinId, $this->qty);

            $this->testResultsAvailable = true;
    
            $this->testResultHtml = view('components.fund-snapshot', ['fundSnapshot' => $fundSnapshot])->render();
        }
        catch(Throwable $t)
        {
            $this->testResultHtml = '<div class="fundSnapshot"><p>Failed to retrieve fund snapshot. Please try again.</p></div>';
        }
    }

    public function testFresh(FundSnapshotService $fundSnapshotService, CoinInfoService $coinInfoService)
    {
        try
        {
            $coinInfoService->refreshCoinInfoCache();
        
            $this->test($fundSnapshotService);
        }
        catch(Throwable $t)
        {
            $this->testResultHtml = '<div class="fundSnapshot"><p>Failed to retrieve fund snapshot. Please try again.</p></div>';
        }
    }

    public function submit()
    {
        $this->validate();
 
        // Execution doesn't reach here if validation fails.

        CoinInvestment::create([
            'fund_id' => $this->fund->id,
            'coin_id' => $this->coinId,
            'coin_name' => $this->coinName,
            'qty' => $this->qty
        ]);

        return redirect()->to(route('funds.show', [
            'fund' => $this->fund
        ]).'#investments');
    }

    public function render()
    {
        $coins = [];

        $coinInfoService = App::make(CoinInfoService::class);

        $coins = $coinInfoService->findCoinsThatContain($this->search);

        return view('livewire.coin-search-and-create', [
            'fund' => $this->fund,
            'coins' => $coins
        ]);
    }
}
