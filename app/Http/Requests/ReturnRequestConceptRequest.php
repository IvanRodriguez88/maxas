<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnRequestConceptRequest extends FormRequest
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
            'return_request_id' => 'required',
            'amount' => 'required',
            'unit_type_id' => 'required',
            'unit_price' => 'required|numeric',
            'total' => 'required|numeric',
        ];
    }

    
	public function attributes()
	{
		return [
			'return_request_id' => 'Folio',
            'amount' => 'Cantidad',
			'unit_type_id' => 'Unidad',
            'unit_price' => 'Precio unitario',
            'total' => 'Importe'
		];
	}
}
