<?php

namespace App\Http\Livewire\Web;

use App\Http\Livewire\Honeypot;
use App\Services\Subscribe;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;

class SubscriptionFormModal extends Honeypot
{
    public $subscription_firstname;
    public $subscription_lastname;
    public $subscription_email;
    public $subscription_subscription_type;
    public $subscription_coupon = '';

    protected function rules()
    {
        $couponCodes = array_keys( config('cashier_coupons.coupons', []) );

        Log::debug('Coupon codes: '.implode(', ', $couponCodes));

        return [
            'subscription_firstname' => 'required|string|max:255',
            'subscription_lastname' => 'required|string|max:255',
            'subscription_email' => 'required|email:rfc,dns',
            'subscription_subscription_type' => 'required|in:monthly,annual',
            'subscription_coupon' => [
                'nullable',
                Rule::in($couponCodes)
            ]
        ];
    }

    public function processForm()
    {
        $this->validate();
 
        // Execution doesn't reach here if validation fails.

        Log::debug("Starting knowledge base registration from page modal");

        $subscribeService = App::make(Subscribe::class);

        try
        {
            $result = $subscribeService->subscribe($this->subscription_email, $this->subscription_firstname, $this->subscription_lastname, $this->subscription_subscription_type, $this->subscription_coupon);

            return redirect()->to(
                $result->getTargetUrl(),
                $result->getStatusCode(),
                $result->headers
            );
        }
        catch( \Exception $e)
        {
            return back()->withErrors([
                'subscription_email' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.web.subscription-form-modal');
    }
}
