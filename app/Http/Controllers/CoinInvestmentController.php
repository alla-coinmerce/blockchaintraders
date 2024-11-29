<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCoinInvestmentRequest;
use App\Models\CoinInvestment;
use App\Models\Fund;

class CoinInvestmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Fund $fund)
    {
        return view('admin.coin-investments.create', [
            'fund' => $fund
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund, CoinInvestment $coininvestment)
    {
        return view('admin.coin-investments.edit', [
            'fund' => $fund,
            'coinInvestment' => $coininvestment,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund, CoinInvestment $coininvestment)
    {
        $coininvestment->delete();

        return redirect()->to(route('funds.show', [
            'fund' => $fund
        ]).'#investments');
    }
}
