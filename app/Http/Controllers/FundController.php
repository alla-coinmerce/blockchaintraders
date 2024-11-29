<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Http\Requests\StoreFundRequest;
use App\Http\Requests\UpdateFundRequest;
use App\Models\Factsheet;
use App\Models\FundValue;
use App\Models\Participation;
use App\Services\CurrencyFormatter;
use App\Services\DeribitService;
use App\Services\StringToSlugConverter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.fund.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.fund.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFundRequest  $request
     * @param  \App\Services\StringToSlugConverter $converter
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFundRequest $request, StringToSlugConverter $converter)
    {
        $fund = Fund::create([
            'name' => $request->name,
            'slug' => $converter->getSlugFromString($request->name),
            'public' => $request->has('public'),
            'auto_update_enabled' => false,
            'extrapolate_enabled' => false,
            'extrapolation_factor' => null
        ]);

        return Redirect::route('funds.show', ['fund' => $fund]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function show(DeribitService $deribitService, Fund $fund)
    {
        $fundValueEurocents = $fund->currentFundValue ? $fund->currentFundValue->value_eurocents : 0;

        $participants = $fund->participants();

        $totalQty = 0;
        foreach($participants as $participant)
        {
            $totalQty += $participant->participationsQtyForFund;
        }

        $currencyFormatter = App::make(CurrencyFormatter::class);
        $totalEuros = $currencyFormatter->formatCurrency($totalQty * $fundValueEurocents);

        // Check if deribit is connected to this fund
        $isDeribitConnectedToFund = $fund->deribitConnection ? true : false;

        return view('admin.fund.show', [
            'fund' => $fund,
            'participants' => $participants,
            'totalQty' => $totalQty,
            'totalEuros' => $totalEuros,
            'isDeribitConnectedToFund' => $isDeribitConnectedToFund,
            'deribitBitCoinQty' => $deribitService->getBitcoinQty(),
            'deribitEthereumQty' => $deribitService->getEthereumQty(),
            'usdcQty' => $deribitService->getUsdcQty()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function edit(Fund $fund)
    {
        return view('admin.fund.edit', ['fund' => $fund]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFundRequest  $request
     * @param  \App\Services\StringToSlugConverter $converter
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFundRequest $request, StringToSlugConverter $converter, Fund $fund)
    {
        $fund->name = $request->name;
        $fund->slug = $converter->getSlugFromString($request->name);
        $fund->public = $request->has('public');
        $fund->start_fund_value_id = $request->has('startDate') ? $request->startDate : null;
        $fund->auto_update_enabled = $request->has('auto_update_enabled');
        $fund->extrapolate_enabled = $request->has('extrapolate_enabled');
        $fund->extrapolation_factor = $request->has('extrapolation_factor') ? $request->extrapolation_factor : null;

        $fund->save();

        return Redirect::route('funds.show', ['fund' => $fund]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund)
    {
        try
        {
            DB::beginTransaction();

            $factsheets = Factsheet::where('fund_id', $fund->id)->get();

            foreach($factsheets as $factsheet)
            {
                Storage::delete($factsheet->storage_path);
            }

            Factsheet::where('fund_id', $fund->id)->delete();
            FundValue::where('fund_id', $fund->id)->delete();
            Participation::where('fund_id', $fund->id)->delete();

            $fund->delete();

            DB::commit();
        }
        catch( \Exception $e)
        {
            Log::error('Failed to delete user. '.$e->getMessage());

            DB::rollBack();

            return back()->withInput();
        }

        return Redirect::route('funds.index');
    }
}
