<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function updatePaymentMethod(Request $request)
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        return $user->updatePaymentMethod()->create();
    }
}