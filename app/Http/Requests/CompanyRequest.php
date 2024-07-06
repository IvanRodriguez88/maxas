<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'group_id' => 'required',
            'bank_separation_id' => 'required',
            'account_status_id' => 'required',
            'intermediary_id' => 'required',
            'company_level_id' => 'required',
            'name' => 'required',
            'social_object' => 'required',
            'comission' => 'required|min:0|max:100',
        ];
    }

    
	public function attributes()
	{
		return [
			'group_id' => 'Grupo',
            'bank_separation_id' => 'Separación de banco',
            'account_status_id' => 'Estado',
            'intermediary_id' => 'Intermediario',
            'company_level_id' => 'Nivel de empresa',
            'name' => 'Nombre',
            'social_object' => 'Objeto social',
            'comission' => 'Comisión',
		];
	}
}
