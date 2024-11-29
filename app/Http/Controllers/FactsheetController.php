<?php

namespace App\Http\Controllers;

use App\Models\Factsheet;
use App\Http\Requests\StoreFactsheetRequest;
use App\Models\Fund;
use App\Models\User;
use App\Notifications\NewFactsheetNotification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class FactsheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Fund $fund
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Fund $fund)
    {
        return view('admin.factsheet.create', ['fund' => $fund]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFactsheetRequest  $request
     * @param \App\Models\Fund $fund
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFactsheetRequest $request, Fund $fund)
    {
        $path = $request->file('file')->store('factsheets');

        $factsheet = Factsheet::create([
            'fund_id' => $fund->id,
            'week' => $request->week,
            'year' => $request->year,
            'original_file_name' => $request->file('file')->getClientOriginalName(),
            'storage_path' => $path,
        ]);

        if($request->has('notify'))
        {
            $users = $factsheet->fund->users;

            foreach($users as $user)
            {
                $user->notify(new NewFactsheetNotification($fund, $factsheet));
            }
        }

        return Redirect::route('funds.show', ['fund' => $fund]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Fund $fund
     * @param  \App\Models\Factsheet  $factsheet
     * @return \Illuminate\Http\Response
     */
    // public function show(Fund $fund, Factsheet $factsheet)
    // {
    //     return response()->file(Storage::path($factsheet->storage_path));
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @param int $year
     * @param int $week
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund, $year, $week)
    {
        $factsheet = Factsheet::where('fund_id', $fund->id)
            ->where('year', $year)
            ->where('week', $week)
            ->firstOrfail();
            
        return response()->file(Storage::path($factsheet->storage_path));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Factsheet  $factsheet
     * @return \Illuminate\Http\Response
     */
    // public function edit(Factsheet $factsheet)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFactsheetRequest  $request
     * @param  \App\Models\Factsheet  $factsheet
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateFactsheetRequest $request, Factsheet $factsheet)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Fund $fund
     * @param  \App\Models\Factsheet  $factsheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund, Factsheet $factsheet)
    {
        Storage::delete($factsheet->storage_path);

        $factsheet->delete();

        return Redirect::route('funds.show', ['fund' => $fund]);
    }
}
