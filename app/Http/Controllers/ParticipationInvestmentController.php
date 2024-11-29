<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateParticipationInvestmentRequest;
use App\Models\Fund;
use App\Models\Participation;
use App\Models\Tag;
use Illuminate\Support\Facades\Redirect;

class ParticipationInvestmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Fund $fund)
    {
        return view('admin.participation-investments.create', [
            'fund' => $fund
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fund $fund, Participation $participationinvestment)
    {
        return view('admin.participation-investments.edit', [
            'fund' => $fund,
            'participationInvestment' => $participationinvestment,
            'tags' => Tag::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParticipationInvestmentRequest $request, Fund $fund, Participation $participationinvestment)
    {
        $tagName = '-';

        if(!empty($request->tag))
        {
            $tagName = $request->tag;
        }

        $tag = Tag::firstOrCreate([
            'name' => $tagName
        ]);

        $participationinvestment->qty = $request->qty;
        $participationinvestment->tag_id = $tag->id;

        $participationinvestment->save();

        return redirect()->to(route('funds.show', [
            'fund' => $fund
        ]).'#investments');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fund $fund, Participation $participationinvestment)
    {
        $participationinvestment->delete();

        return redirect()->to(route('funds.show', [
            'fund' => $fund
        ]).'#investments');
    }
}
