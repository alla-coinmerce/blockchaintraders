<?php

namespace App\Http\Livewire;

use App\Exceptions\CoinInfoException;
use App\Services\CoinInfoService;
use App\Services\FundSnapshotService;
use Livewire\Component;
use Throwable;

class CoinInvestmentEdit extends Component
{
    /**
     * @var \App\Models\Fund
     */
    public $fund;

    /**
     * @var \App\Models\CoinInvestment
     */
    public $coinInvestment;

    public $formattedCoinValue = 'Unknown';

    public $qty;

    public $testResultsAvailable = false;
    public $testResultHtml = '';

    protected $rules = [
        'qty' => 'required|decimal:0,6',
    ];

    public function mount(CoinInfoService $coinInfoService)
    {
        $this->qty = $this->coinInvestment->qty;

        try
        {
            $coin = $coinInfoService->getCoin($this->coinInvestment->coin_id);

            $this->formattedCoinValue = $coin->formattedCoinValueInEuros();
        }
        catch(CoinInfoException $e)
        {
            report($e);
        }
    }

    public function test(FundSnapshotService $fundSnapshotService)
    {
        try
        {
            $fundSnapshot = $fundSnapshotService->getSnapshotWithUpdatedCoin($this->fund, $this->coinInvestment, $this->qty);

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

        $this->coinInvestment->qty = $this->qty;

        $this->coinInvestment->save();

        return redirect()->to(route('funds.show', [
            'fund' => $this->fund
        ]).'#investments');
    }

    public function render()
    {
        return view('livewire.coin-investment-edit');
    }
}
