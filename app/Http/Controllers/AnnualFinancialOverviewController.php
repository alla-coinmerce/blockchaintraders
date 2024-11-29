<?php

namespace App\Http\Controllers;

use App\Models\AnnualFinancialOverview;
use App\Http\Requests\StoreAnnualFinancialOverviewRequest;
use App\Http\Requests\UpdateAnnualFinancialOverviewRequest;
use App\Models\User;
use App\Notifications\NewAnnualFinancialOverviewNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AnnualFinancialOverviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        return view('admin.annualfinancialoverview.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAnnualFinancialOverviewRequest  $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAnnualFinancialOverviewRequest $request, User $user)
    {
        $path = $request->file('file')->store('userdocs/'.$user->id.'/annualfinancialoverviews');

        $annualFinancialOverview = AnnualFinancialOverview::create([
            'user_id' => $user->id,
            'year' => 0,
            'original_file_name' => $request->file('file')->getClientOriginalName(),
            'storage_path' => $path,
        ]);

        if($request->has('notify'))
        {
            $user->notify(new NewAnnualFinancialOverviewNotification($annualFinancialOverview));
        }

        return Redirect::route('users.show', ['user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnnualFinancialOverview  $annualFinancialOverview
     * @return \Illuminate\Http\Response
     */
    // public function show(AnnualFinancialOverview $annualFinancialOverview)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnnualFinancialOverview  $annualFinancialOverview
     * @param int $year
     * @return \Illuminate\Http\Response
     */
    public function show(AnnualFinancialOverview $annualFinancialOverview, $year)
    {
        // dd($annualFinancialOverview->storage_path);
        return response()->file(Storage::path($annualFinancialOverview->storage_path));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AnnualFinancialOverview  $annualFinancialOverview
     * @param int $year
     * @return \Illuminate\Http\Response
     */
    public function show_for_auth_user($id, $name)
    {
        $annualFinancialOverview = AnnualFinancialOverview::where('id', $id)
            ->where('original_file_name', $name)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return response()->file(Storage::path($annualFinancialOverview->storage_path));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AnnualFinancialOverview  $annualFinancialOverview
     * @return \Illuminate\Http\Response
     */
    // public function edit(AnnualFinancialOverview $annualFinancialOverview)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAnnualFinancialOverviewRequest  $request
     * @param  \App\Models\AnnualFinancialOverview  $annualFinancialOverview
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateAnnualFinancialOverviewRequest $request, AnnualFinancialOverview $annualFinancialOverview)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @param  \App\Models\AnnualFinancialOverview  $annualFinancialOverview
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, AnnualFinancialOverview $annualFinancialOverview)
    {
        Storage::delete($annualFinancialOverview->storage_path);

        $annualFinancialOverview->delete();

        return Redirect::route('users.show', ['user' => $user]);
    }
}
