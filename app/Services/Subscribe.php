<?php

namespace App\Services;

use App\Enums\Role;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Cashier\SubscriptionBuilder\RedirectToCheckoutResponse;

class Subscribe
{
    public function subscribe(string $email, string $firstName, string $lastName, string $subscriptionType, string $coupon = '')
    {
        $user = User::where('email', $email)->first();

        $result = null;

        try
        {
            Log::debug("Starting database transaction");

            DB::beginTransaction();

            // Existing user?
            if($user)
            {
                Log::debug("Existing user: ".$user->firstname.' '.$user->lastname);

                // Check if not already subscribed when user already exists.
                if(! $user->subscribed('knowlegde_base'))
                {
                    // Create subscription.
                    $result = $this->createSubscription($user, $subscriptionType, $coupon);
                }
                else
                {
                    Log::debug("User ".$user->firstname.' '.$user->lastname." is already subscribed");

                    throw new \Exception( __("Already subscribed") );
                }
            }
            else
            {
                Log::debug("Creating new user");

                // Create user.
                $user = User::create([
                    'role' => Role::SUBSCRIBER->value,
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'email' => $email,
                    'password' => Hash::make(Str::random(14)),
                    'active' => false
                ]);

                Log::debug("User created");

                // Create subscription.
                $result = $this->createSubscription($user, $subscriptionType, $coupon);
            }

            DB::commit();
        }
        catch(\Exception $e)
        {
            Log::error('Failed to subscribe user. '.$e->getMessage());

            DB::rollBack();

            throw new \Exception( __("Subscribing failed. If the error keeps occuring please contact us.") );
        }

        if($result)
        {
            Log::debug("Returning result");
            
            return $result;
        }
        else
        {
            Log::debug("Returning back without going to Mollie");

            return back();
        }
    }

    private function createSubscription(User $user, string $plan, string $coupon = ''): RedirectResponse
    {
        Log::debug("Start creating subscription");

        $subscriptionBuilder = $user->newSubscription('knowlegde_base', $plan)
                                    ->trialDays(7);

        if(!empty($coupon))
        {
            Log::debug('Applying coupon: '.$coupon);

            $subscriptionBuilder->withCoupon($coupon);
        }

        $result = $subscriptionBuilder->create();

        if(is_a($result, RedirectToCheckoutResponse::class))
        {
            Log::debug("Result is a redirect to Mollie");

            return $result; // Redirect to Mollie checkout
        }

        Log::debug("Already subscribed");

        return back()->withErrors([
            'email' => __("Already subscribed")
        ]);
    }
}