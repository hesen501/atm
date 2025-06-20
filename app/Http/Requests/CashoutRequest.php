<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CashoutRequest extends FormRequest
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
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required|integer|min:1',
            'currency_id' => 'required|exists:currencies,id',
        ];
    }
}
