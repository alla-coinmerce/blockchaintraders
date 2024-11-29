<?php

namespace App\Http\Requests;

use App\Models\Fund;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFactsheetRequest extends FormRequest
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
            'week' =>'required|integer|min:1|max:53',
            'year' =>'required|integer|min:2000|max:2500',
            'file' =>'required|mimes:pdf,html,htm|file|mimetypes:text/html,application/pdf',
        ];
    }
}
