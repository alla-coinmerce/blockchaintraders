<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class StorePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!hash_equals((string) $this->hash, sha1($this->user->getEmailForVerification())))
        {
            return false;
        }

        // User is already activated
        if(is_null($this->user->welcome_valid_until))
        {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'hash' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => [
                'required',
                'confirmed',
                new Password
            ]
        ];
    }
}
