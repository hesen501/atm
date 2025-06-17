<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'currency_id' => [
                'required',
                'exists:currencies,id',
                Rule::unique('accounts')->where(function ($query) {
                    return $query->where('user_id', $this->input('user_id'));
                }),
            ],
            'amount' => 'required|integer',
        ];
    }
}
