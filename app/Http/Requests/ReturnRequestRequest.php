<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnRequestRequest extends FormRequest
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
            'client_id' => 'required',
            'company_id' => 'required',
            'account_id' => 'required',
            'return_base_id' => 'required',
            'request_type_id' => 'required',
            'client_payment_proof' => 'file|mimes:pdf|max:2048',
        ];
    }

    
	public function attributes()
	{
		return [
			'client_id' => 'Cliente',
            'company_id' => 'Empresa',
			'account_id' => 'Cuenta',
            'return_base_id' => 'Base de retorno',
            'request_type_id' => 'Tipo de solicitud',
            'client_payment_proof' => 'Comprobante de pago'
		];
	}
}
