<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserDocumentRequest;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class UserDocumentController extends Controller
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
        return view('admin.document.create', ['user' => $user]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserDocumentRequest  $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserDocumentRequest $request, User $user)
    {
        $path = $request->file('file')->store('userdocs/'.$user->id);

        $document = UserDocument::create([
            'user_id' => $user->id,
            'display_name' => $request->display_name,
            'original_file_name' => $request->file('file')->getClientOriginalName(),
            'storage_path' => $path,
        ]);

        return Redirect::route('users.show', ['user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserDocument  $document
     * @return \Illuminate\Http\Response
     */
    public function show(UserDocument $document)
    {
        return response()->file(Storage::path($document->storage_path));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\User $user
     * @param  \App\Models\UserDocument  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, UserDocument $document)
    {
        Storage::delete($document->storage_path);

        $document->delete();

        return Redirect::route('users.show', ['user' => $user]);
    }
}
