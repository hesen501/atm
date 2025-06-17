<?php

namespace App\Http\Requests\BankNote;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'currency_id' => 'required|exists:currencies,id',
            'denomination' => 'required|integer|min:1',
            'count' => 'required|integer|min:0',
        ];
    }
}
