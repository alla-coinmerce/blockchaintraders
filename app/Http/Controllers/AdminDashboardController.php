<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $funds = Fund::all();

        $dashboard_fund_1 = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_1'],
            ['value' => 1]
        );

        $dashboard_fund_1_participation_start_date = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_1_participation_start_date'],
            ['value' => today()->format('Y-m-d')]
        );

        $dashboard_fund_2 = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_2'],
            ['value' => 2]
        );

        $dashboard_fund_2_participation_start_date = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_2_participation_start_date'],
            ['value' => today()->format('Y-m-d')]
        );

        return view('admin.home', [
            'funds' => $funds,
            'dashboard_fund_1' => $dashboard_fund_1->value,
            'dashboard_fund_1_participation_start_date' => $dashboard_fund_1_participation_start_date->value,
            'dashboard_fund_2' => $dashboard_fund_2->value,
            'dashboard_fund_2_participation_start_date' => $dashboard_fund_2_participation_start_date->value
        ]);
    }
}
