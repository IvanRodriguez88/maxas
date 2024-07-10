<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;

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
        $userId = null;
		if ($this->isMethod('put')) {
			$userId = $this->route('promotor')->user_id; // Obtener el ID del usuario actualmente en edición
		}

        return [
            'name' => 'required|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
				Rule::unique('users')->ignore($userId), // Ignorar el correo electrónico del usuario actual
            ],
			'password' => ($this->isMethod('put') ? 'nullable|' : 'required|') . 'max:255', // Hacer el campo password opcional en edición
            'comission_ban' => 'required|numeric|min:0|max:100',
            'comission_flu' => 'required|numeric|min:0|max:100',
            'comission_nom' => 'required|numeric|min:0|max:100',
            'account_number' => 'required',
            'balance' => 'numeric',
        ];
    }

    
	public function attributes()
	{
		return [
			'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'comission_ban' => 'Comisión bancarización',
            'comission_flu' => 'Comisión flujo',
            'comission_nom' => 'Comisión nóminas',
            'account_number' => 'Cuenta o clabe',
            'balance' => "Saldo"
		];
	}
}
