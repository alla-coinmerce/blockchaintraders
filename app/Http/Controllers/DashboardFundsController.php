<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrUpdateDasboardFundRequest;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardFundsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\StoreOrUpdateDasboardFundRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreOrUpdateDasboardFundRequest $request)
    {
        Setting::updateOrCreate(
            ['setting' => 'dashboard_fund_1'],
            ['value' => $request->dashboard_fund_1]
        );

        Setting::updateOrCreate(
            ['setting' => 'dashboard_fund_1_participation_start_date'],
            ['value' => $request->dashboard_fund_1_participation_start_date]
        );

        Setting::updateOrCreate(
            ['setting' => 'dashboard_fund_2'],
            ['value' => $request->dashboard_fund_2]
        );

        Setting::updateOrCreate(
            ['setting' => 'dashboard_fund_2_participation_start_date'],
            ['value' => $request->dashboard_fund_2_participation_start_date]
        );

        return back();
    }
}
