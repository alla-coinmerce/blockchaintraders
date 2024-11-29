<?php

namespace App\Http\Controllers;

use App\Models\User;

class Subscriber extends Controller
{
    public function index()
    {
        $users = User::whereHas('subscriptions')->get();

        return view('admin.subscriber.index', [
            'users' => $users
        ]);
    }

    public function delete(User $user)
    {
        if($user->subscription('knowlegde_base'))
        {
            $user->subscription('knowlegde_base')->cancel();
        }

        return back();
    }
}