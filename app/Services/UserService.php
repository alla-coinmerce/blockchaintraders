<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class UserService
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;


    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the authenticated user with all it's participation data
     * 
     * @return
     */
    public function getAuthUserWithParticipationData()
    {
        $id = Auth::id();
    }

    /**
     * Get the user with all it's participation data
     * based on the request route user parameter
     * 
     * @return
     */
    public function getRequestUserWithParticipationData()
    {
        $this->request->route('user');
    }
}