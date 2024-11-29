<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserDocumentRequest extends FormRequest
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
            'display_name' =>'required|string|max:250',
            'file' =>'required|mimes:pdf,html,jpg,jpeg,png,bmp|file|mimetypes:text/html,application/pdf,image/bmp,image/jpeg,image/x-png,image/png',
        ];
    }
}
