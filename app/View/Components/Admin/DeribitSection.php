<?php

namespace App\View\Components\Admin;

use App\Models\DeribitConnection;
use App\Services\DeribitService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeribitSection extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        private DeribitService $deribitService
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // Check if connected to a fund
        $deribitConnection = DeribitConnection::first();

        $isConnectedToFund = $deribitConnection ? true : false;
        
        // If connected get the fund name
        $fundName = $isConnectedToFund ? $deribitConnection->fund->name : '';

        return view('components.admin.deribit-section', [
            'isConnectedToFund' => $isConnectedToFund,
            'fundName' => $fundName,
            'deribitBitCoinQty' => $this->deribitService->getBitcoinQty(),
            'deribitEthereumQty' => $this->deribitService->getEthereumQty(),
            'usdcQty' => $this->deribitService->getUsdcQty()
        ]);
    }
}
