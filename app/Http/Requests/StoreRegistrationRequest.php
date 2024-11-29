<?php

namespace App\Http\Requests;

use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class StoreRegistrationRequest extends FormRequest
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
        // dd($this);

        $country_whitelist = Array();
        foreach(Countries::getNames() as $alpha2Code => $countryName)
        {
            $country_whitelist[] = $alpha2Code;
        }

        return [
            'registration_type' => 'required|in:private,entity',
            'company_name' => 'required_if:registration_type,entity|max:255|nullable',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'zipcode' => 'required|string|max:8',
            'city' => 'required|string|max:255',
            'country_code' => [
                'required',
                Rule::in($country_whitelist)
            ],
            'nationality_code' => [
                'required',
                Rule::in($country_whitelist)
            ],
            'phone' => 'required|min:10|max:20',
            'email' => 'required|email:rfc,dns',
            'birthdate' => 'required|date',
            'birth_country_code' => [
                'required',
                Rule::in($country_whitelist)
            ],
            'identification' => 'required|mimes:pdf,jpg,jpeg,png,bmp|file|mimetypes:application/pdf,image/bmp,image/jpeg,image/x-png,image/png',
            'bank_statement' => 'required_if:registration_type,private|mimes:pdf,jpg,jpeg,png,bmp|file|mimetypes:application/pdf,image/bmp,image/jpeg,image/x-png,image/png',
            'coc_extract' => 'required_if:registration_type,entity|mimes:pdf,jpg,jpeg,png,bmp|file|mimetypes:application/pdf,image/bmp,image/jpeg,image/x-png,image/png',
            'participation_date' => 'required|date',
            'participation_moment' => 'required|in:morning,afternoon',
            'desired_amount' => 'required|string|max:255',
            'living_in_netherlands' => 'required|in:yes,no',
            'source_of_income' => 'required_if:registration_type,private|string|max:255|nullable',
            'taxable_countries' => 'required|string|max:255',
            'bsn' => 'required|string|max:64',
            'coc_number' => 'required_if:registration_type,entity|string|max:64|nullable',
            'bank_account_number' => 'required|string|max:64',
            'correctly_filled' => 'accepted',
            'confirmation' => 'accepted'
        ];
    }
}
