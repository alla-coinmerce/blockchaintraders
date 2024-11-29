<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StoreSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
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
}
