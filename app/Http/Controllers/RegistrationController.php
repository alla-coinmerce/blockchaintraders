<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\StoreRegistrationRequest;
use App\Models\Fund;
use App\Models\PendingRegistration;
use App\Models\User;
use App\Models\UserDocument;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Fund $fund
     * @return \Illuminate\Http\Response
     */
    public function create(Fund $fund)
    {
        if(!$fund->public)
        {
            abort(404);
        }

        return view('web.register', [
            'fund' => $fund
        ]);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\StoreRegistrationRequest  $request
     * @param \App\Models\Fund $fund
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegistrationRequest $request, Fund $fund)
    {
        Log::debug("Starting registration for ".$request->firstname." ".$request->lastname);

        if(!$fund->public)
        {
            Log::debug("Fund is not public: ".$fund->name);

            abort(404);
        }
        
        try
        {
            DB::beginTransaction();

            $note = 'Participate in fund '.$fund->name;
            $note .= ' from date '.$request->participation_date.' ('.$request->participation_moment.')';
            $note .= ' with desired amount '.$request->desired_amount.'.';

            $user = User::where('email', $request->email)->first();

            if(!$user)
            {
                $user = User::create([
                    'role' => Role::PARTICPANT->value,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make(Str::random(14)),
                    'active' => false,
                    'registration_type' => $request->registration_type,
                    'company_name' => $request->company_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'zipcode' => $request->zipcode,
                    'city' => $request->city,
                    'country_code' => $request->country_code,
                    'nationality_code' => $request->nationality_code,
                    'birthdate' => $this->formatDate($request->birthdate),
                    'birth_country_code' => $request->birth_country_code,
                    'living_in_netherlands' => $request->living_in_netherlands === 'yes' ? true : false,
                    'source_of_income' => $request->source_of_income,
                    'taxable_countries' => $request->taxable_countries,
                    'bsn' => $request->bsn,
                    'tax_number' => $request->tax_number,
                    'bank_account_number' => $request->bank_account_number,
                    'coc_number' => $request->coc_number,
                    'notes' => $note, 
                    'demo_account' => false
                ]);

                Log::debug("User created");
            }
            else
            {
                // Check if the user is subscribed to the knowledge base
                if($user->role === Role::SUBSCRIBER->value)
                {
                    $user->update([
                        'role' => Role::BOTH->value
                    ]);
                }

                $user->update([
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'registration_type' => $request->registration_type,
                    'company_name' => $request->company_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'zipcode' => $request->zipcode,
                    'city' => $request->city,
                    'country_code' => $request->country_code,
                    'nationality_code' => $request->nationality_code,
                    'birthdate' => $this->formatDate($request->birthdate),
                    'birth_country_code' => $request->birth_country_code,
                    'living_in_netherlands' => $request->living_in_netherlands === 'yes' ? true : false,
                    'source_of_income' => $request->source_of_income,
                    'taxable_countries' => $request->taxable_countries,
                    'bsn' => $request->bsn,
                    'tax_number' => $request->tax_number,
                    'bank_account_number' => $request->bank_account_number,
                    'coc_number' => $request->coc_number,
                    'notes' => $user->notes.' '.$note // Extend the existing notes
                ]);
            }

            $pendingRegistrationData = [
                'user_id' => $user->id,
                'fund_name' => $fund->name,
                'desired_participation_date' => $request->participation_date,
                'desired_amount' => $request->desired_amount
            ];

            $date = Carbon::now()->format('Y-m-d');

            $path = $request->file('identification')->store('userdocs/'.$user->id);

            $doc = UserDocument::create([
                'user_id' => $user->id,
                'display_name' => 'identity_'.$date,
                'original_file_name' => $request->file('identification')->getClientOriginalName(),
                'storage_path' => $path,
            ]);

            $pendingRegistrationData['identification'] = $doc->id;

            Log::debug("Identification stored");

            if($request->registration_type === 'private')
            {
                $path = $request->file('bank_statement')->store('userdocs/'.$user->id);

                $doc = UserDocument::create([
                    'user_id' => $user->id,
                    'display_name' => 'bank_statement_'.$date,
                    'original_file_name' => $request->file('bank_statement')->getClientOriginalName(),
                    'storage_path' => $path,
                ]);

                $pendingRegistrationData['bank_statement'] = $doc->id;

                Log::debug("Bank statement stored");
            }

            if($request->registration_type === 'entity')
            {
                $path = $request->file('coc_extract')->store('userdocs/'.$user->id);

                $doc = UserDocument::create([
                    'user_id' => $user->id,
                    'display_name' => 'kvk_'.$date,
                    'original_file_name' => $request->file('coc_extract')->getClientOriginalName(),
                    'storage_path' => $path,
                ]);

                $pendingRegistrationData['coc_extract'] = $doc->id;

                Log::debug("COC extract stored");
            }

            PendingRegistration::create($pendingRegistrationData);

            Log::debug("Committing database transaction");

            DB::commit();
        }
        catch( \Exception $e)
        {
            Log::error('Failed to register new user. '.$e->getMessage());

            DB::rollBack();

            return back()->withErrors([
                'confirmation' => __("Registration failed. Please refresh the page and try again. If the error keeps occuring please contact us.")
            ]);
        }

        Log::debug("Redirecting to thank you page");

        return Redirect::route('register-thank-you')->with('firstname', $request->firstname);
    }

    private function formatDate($postedDate)
    {
        $date = date_create($postedDate);

        if($date)
        {
            return date_format($date, 'Y-m-d');
        }
        else
        {
            Log::error("Unable to format date ".$postedDate);

            return "0000-00-00";
        }
    }
}
