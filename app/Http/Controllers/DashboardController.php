<?php

namespace App\Http\Controllers;

use App\Dtos\DashboardFund;
use App\Models\Fund;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        /** @var \App\Models\User $user */
        if(!$user->isAdmin())
        {
            abort(404);
        }

        $funds = Array();

        $dashboard_fund_1 = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_1'],
            ['value' => 1]
        );

        $funds[0]['participationStartDate'] = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_1_participation_start_date'],
            ['value' => today()->format('Y-m-d')]
        );

        $funds[0]['fund'] = Fund::with('fundvalues')
            ->where('id', $dashboard_fund_1->value)
            ->first();

        $dashboard_fund_2 = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_2'],
            ['value' => 2]
        );

        $funds[1]['participationStartDate'] = Setting::firstOrCreate(
            ['setting' => 'dashboard_fund_2_participation_start_date'],
            ['value' => today()->format('Y-m-d')]
        );

        $funds[1]['fund'] = Fund::with('fundvalues')
            ->where('id', $dashboard_fund_2->value)
            ->first();

        $fundDtos = Array();

        foreach($funds as $fund)
        {
            $fundDtos[] = new DashboardFund($fund['fund'], $fund['participationStartDate']->value);
        }

        $date = ucfirst(today()->translatedFormat('l d M Y'));

        return view('portal.dashboard', [
            'date' => $date,
            'funds' => $fundDtos
        ]);
    }
}
