<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'currency_type_id' => 'required',
            'bank_id' => 'required',
            'account_number' => 'required|min:10|max:12',
            'clabe' => 'required|min:16|max:18',
            'ava' => 'required',
            'swift' => 'required'
        ];
    }

    
	public function attributes()
	{
		return [
			'currency_type_id' => 'Tipo de moneda',
            'bank_id' => 'Banco',
            'account_number' => 'Número de cuenta',
            'clabe' => 'Clabe interbancaria',
            'ava' => 'AVA',
            'swift' => 'SWIFT'
		];
	}
}
