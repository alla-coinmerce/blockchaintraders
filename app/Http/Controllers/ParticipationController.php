<?php

namespace App\Http\Controllers;

use App\Models\Participation;
use App\Http\Requests\UpdateParticipationRequest;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;

class ParticipationController extends Controller
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
        return view('admin.participation.create', [
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Http\Response
     */
    // public function show(Participation $participation)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Participation $participation)
    {
        return view('admin.participation.edit', [
            'user' => $user,
            'participation' => $participation,
            'tags' => Tag::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateParticipationRequest  $request
     * @param  \App\Models\User  $user
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateParticipationRequest $request, User $user, Participation $participation)
    {
        $tagName = '-';

        if(!empty($request->tag))
        {
            $tagName = $request->tag;
        }

        $tag = Tag::firstOrCreate([
            'name' => $tagName
        ]);

        $participation->qty = $request->qty;
        $participation->tag_id = $tag->id;

        $participation->save();

        return redirect()->to(route('users.show', [
            'user' => $request->user
        ]).'#participations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Participation  $participation
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Participation $participation)
    {
        $participation->delete();

        return Redirect::route('users.show', ['user' => $user]);
    }
}
