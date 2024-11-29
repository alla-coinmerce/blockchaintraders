<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFundValueRequest extends FormRequest
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
        return [
            'date' => 'required|date',
            'value_eurocents' => 'required|decimal:0,2|between:-100000,100000',
            'value_dollarcents' => 'decimal:0,2|between:-100000,100000|nullable'
        ];
    }
}
