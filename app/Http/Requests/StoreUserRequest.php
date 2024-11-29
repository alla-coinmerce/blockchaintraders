<?php

namespace App\Http\Requests;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Symfony\Component\Intl\Countries;

class StoreUserRequest extends FormRequest
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
        $role_whitelist = Array('none');
        foreach(Role::cases() as $role)
        {
            $role_whitelist[] = $role->value;
        }

        $country_whitelist = Array();
        foreach(Countries::getNames() as $alpha2Code => $countryName)
        {
            $country_whitelist[] = $alpha2Code;
        }

        return [
            'role' => [
                'required',
                Rule::in($role_whitelist)
            ],
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|unique:users|email:rfc,dns|max:255',
            'registration_type' => 'required|in:private,entity',
            'company_name' => 'string|max:255|nullable',
            'address' => 'string|max:255|nullable',
            'zipcode' => 'string|max:8|nullable',
            'city' => 'string|max:255|nullable',
            'country_code' => [
                Rule::in($country_whitelist)
            ],
            'nationality_code' => [
                Rule::in($country_whitelist)
            ],
            'phone' => 'min:10|max:20|nullable',
            'birthdate' => 'date|nullable',
            'birth_country_code' => [
                Rule::in($country_whitelist)
            ],
            'living_in_netherlands' => 'in:yes,no',
            'source_of_income' => 'string|max:255|nullable',
            'taxable_countries' => 'string|max:255|nullable',
            'bsn' => 'string|max:64|nullable',
            'coc_number' => 'string|max:64|nullable',
            'bank_account_number' => 'string|max:64|nullable',
            'notes' => 'string|nullable'
        ];
    }
}
