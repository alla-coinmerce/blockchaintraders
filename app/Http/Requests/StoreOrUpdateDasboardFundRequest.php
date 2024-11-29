<?php

namespace App\Http\Requests;

use App\Models\Fund;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrUpdateDasboardFundRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $fund_whitelist = Array();
        foreach(Fund::all() as $fund)
        {
            $fund_whitelist[] = $fund->id;
        }

        return [
            'dashboard_fund_1' => [
                'required',
                Rule::in($fund_whitelist)
            ],
            'dashboard_fund_2' => [
                'required',
                Rule::in($fund_whitelist)
            ],
        ];
    }
}
