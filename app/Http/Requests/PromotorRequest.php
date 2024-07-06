<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotorRequest extends FormRequest
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
            'name' => 'required|max:255',
            'comission' => 'required|numeric|min:0|max:100',
            'account_number' => 'required',
        ];
    }

    
	public function attributes()
	{
		return [
			'name' => 'Nombre',
            'comission' => 'Comisión',
            'account_number' => 'Cuenta o clabe',
		];
	}
}
