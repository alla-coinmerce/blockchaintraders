<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyAccountController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        /** @var \App\Models\User */
        $user =  Auth::user();

        $subscription = $user->subscription('knowlegde_base');
        
        return view('portal.my-account', [
            'user' => $user,
            'subscription' => $subscription
        ]);
    }
}
