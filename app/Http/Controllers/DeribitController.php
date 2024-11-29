<?php

namespace App\Http\Controllers;

use App\Models\DeribitConnection;
use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DeribitController extends Controller
{
    public function create()
    {
        return view('admin.deribit.connect', [
            'funds' => Fund::all()
        ]);
    }

    public function store(Request $request)
    {
        $fundWhitelist = Array();
        foreach(Fund::all() as $fund)
        {
            $fundWhitelist[] = $fund->id;
        }

        $validated = $request->validate([
            'fund_id' => [
                'required',
                Rule::in($fundWhitelist)
            ]
        ]);

        $fund = Fund::find($validated['fund_id']);

        // Setting the subaccount is to 0 is okay for now, since we don't have subaccounts and there should always be only max. 1 record.
        DeribitConnection::truncate();
        $fund->deribitConnection()->create([
            'subaccount_id' => 0
        ]);

        return to_route('funds.show', [
            'fund' => $fund
        ]);
    }

    public function destroy()
    {
        // Truncate is okay for now, since we don't have subaccounts and there should always be only max. 1 record.
        DeribitConnection::truncate();

        return back();
    }
}
