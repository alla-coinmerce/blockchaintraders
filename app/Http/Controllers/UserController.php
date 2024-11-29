<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AnnualFinancialOverview;
use App\Models\Participation;
use App\Models\UserDocument;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Activates a user
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function activate(User $user)
    {
        if(! $user->hasVerifiedEmail())
        {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        $user->active = true;

        $user->save();
        
        $user->sendWelcomeNotification();
        
        return back();
    }

    /**
     * Resends the WelcomeNotification to the user
     * 
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resendWelcomeNotification(User $user)
    {
        $user->sendWelcomeNotification();

        return back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('active', 'ASC')
            ->orderBy('welcome_valid_until', 'DESC')
            ->orderBy('firstname', 'ASC')
            ->get();

        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'role' => $request->role,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make(Str::random(14)),
            'active' => true,
            'registration_type' => $request->registration_type,
            'company_name' => $request->company_name,
            'address' => $request->address,
            'zipcode' => $request->zipcode,
            'city' => $request->city,
            'country_code' => $request->country_code,
            'nationality_code' => $request->nationality_code,
            'phone' => $request->phone,
            'birthdate' => $request->birthdate,
            'birth_country_code' => $request->birth_country_code,
            'living_in_netherlands' => $request->living_in_netherlands === 'yes' ? true : false,
            'source_of_income' => $request->source_of_income,
            'taxable_countries' => $request->taxable_countries,
            'bsn' => $request->bsn,
            'coc_number' => $request->coc_number,
            'bank_account_number' => $request->bank_account_number,
            'notes' => $request->notes,
            'demo_account' => $request->has('demo_account') ? true : false
        ]);

        $user->sendWelcomeNotification();

        return Redirect::route('users.show', ['user' => $user]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = User::where('id', $user->id)
            ->WithFundParticipations($user->id)
            ->first();
        // dd($user);

        $subscription = $user->subscription('knowlegde_base');

        return view('admin.user.show', [
            'user' => $user,
            'subscription' => $subscription
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->role = $request->role;
        $user->firstname =  $request->firstname;
        $user->lastname =  $request->lastname;
        $user->email =  $request->email;
        $user->registration_type = $request->registration_type;
        $user->company_name = $request->company_name;
        $user->address = $request->address;
        $user->zipcode = $request->zipcode;
        $user->city = $request->city;
        $user->country_code = $request->country_code;
        $user->nationality_code = $request->nationality_code;
        $user->phone = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->birth_country_code = $request->birth_country_code;
        $user->living_in_netherlands = $request->living_in_netherlands === 'yes' ? true : false;
        $user->source_of_income = $request->source_of_income;
        $user->taxable_countries = $request->taxable_countries;
        $user->bsn = $request->bsn;
        $user->coc_number = $request->coc_number;
        $user->bank_account_number = $request->bank_account_number;
        $user->notes = $request->notes;
        $user->demo_account = $request->has('demo_account') ? true : false;

        $user->save();

        return Redirect::route('users.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try
        {
            DB::beginTransaction();

            $user->delete();

            DB::commit();
        }
        catch( \Exception $e)
        {
            Log::error('Failed to delete user. '.$e->getMessage());

            DB::rollBack();

            return back()->withInput();
        }

        return Redirect::route('users.index', ['users' => User::all()]);
    }
}
