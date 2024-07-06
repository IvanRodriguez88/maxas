<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotorClientRequest extends FormRequest
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
            'client_id' => 'required|unique',
            'commission' => 'required|numeric|min:0|max:100',
        ];
    }

    
	public function attributes()
	{
		return [
			'client_id' => 'Cliente',
            'commission' => 'Comisión',
		];
	}
}
