<?php

namespace App\Http\Requests;

use App\Models\Fund;
use Illuminate\Foundation\Http\FormRequest;

class UpdateParticipationRequest extends FormRequest
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
            'qty' => 'required|numeric|min:1',
            'tag' => 'string|max:255|nullable'
        ];
    }
}
