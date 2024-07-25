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
            'bank_separation_id' => 'required',
        ];
    }

    
	public function attributes()
	{
		return [
			'currency_type_id' => 'Tipo de moneda',
            'bank_id' => 'Banco',
            'bank_separation_id' => 'Tipo de banco',
		];
	}
}
