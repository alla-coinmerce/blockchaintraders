<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFundValueRequest;
use App\Http\Requests\UpdateFundValueRequest;
use App\Models\Fund;
use App\Models\FundValue;
use App\Services\Time;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class FundValueController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Fund $fund
     * @return \Illuminate\Http\Response
     */
    public function create(Fund $fund)
    {
        return view('admin.fundvalue.create', ['fund' => $fund]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFundValueRequest  $request
     * @param \App\Models\Fund $fund
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFundValueRequest $request, Fund $fund)
    {
        $dateTime =  App::make(Time::class)->dateTimeFromDateSetToTwelveHourEuropeAmsterdamTime($request->date);

        $fund->fundValues()->create([
            'value_eurocents' => $request->value_eurocents * 100,
            'value_dollarcents' => ($request->value_dollarcents !== null) ? $request->value_dollarcents * 100 : null,
            'date_time' => $dateTime,
            'date' => $request->date,
            'time' => $dateTime->format('H:i:s')
        ]);

        return Redirect::route('funds.show', ['fund' => $fund]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Fund $fund
     * @param  \App\Models\FundValue  $fundvalue
     * @return \Illuminate\Http\Response
     */
    public function edit(Fund $fund, FundValue $fundvalue)
    {
        return view('admin.fundvalue.edit', ['fund' => $fund, 'fundvalue' => $fundvalue]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFundValueRequest  $request
     * @param \App\Models\Fund $fund
     * @param  \App\Models\FundValue  $fundvalue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFundValueRequest $request, Fund $fund, FundValue $fundvalue)
    {
        $dateTime =  App::make(Time::class)->dateTimeFromDateSetToTwelveHourEuropeAmsterdamTime($request->date);

        $fundValue = FundValue::where('date', $fundvalue->date)->where('value_eurocents', $fundvalue->value_eurocents)->first();

        if($fundValue)
        {
            $fundValue->date_time = $dateTime;
            $fundValue->date = $request->date;
            $fundValue->value_eurocents = $request->value_eurocents * 100;
            $fundValue->value_dollarcents = ($request->value_dollarcents !== null) ? $request->value_dollarcents * 100 : null;

            $fundValue->save();
        }

        $fundvalue->date = $request->date;
        $fundvalue->value_eurocents = $request->value_eurocents * 100;
        $fundvalue->value_dollarcents = ($request->value_dollarcents !== null) ? $request->value_dollarcents * 100 : null;

        $fundvalue->save();

        return Redirect::route('funds.show', ['fund' => $fund]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Fund $fund
     * @param  \App\Models\FundValue  $fundValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund, FundValue $fundvalue)
    {
        $fundValue = FundValue::where('date', $fundvalue->date)->where('value_eurocents', $fundvalue->value_eurocents)->first();
        $fundValue->delete();

        $fundvalue->delete();

        return Redirect::route('funds.show', ['fund' => $fund]);
    }
}
