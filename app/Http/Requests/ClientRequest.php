<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class ClientRequest extends FormRequest
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
			$userId = $this->route('client')->user_id; // Obtener el ID del usuario actualmente en edición
		}

        return [
            'name' => 'required|max:255',
            'client_type_id' => 'required',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
				Rule::unique('users')->ignore($userId), // Ignorar el correo electrónico del usuario actual
            ],
			'password' => ($this->isMethod('put') ? 'nullable|' : 'required|') . 'max:255', // Hacer el campo password opcional en edición
            'rfc' => 'required',
            'street_and_number' => 'required',
            'cologne' => 'required',
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'comission_ban' => 'required',
            'comission_flu' => 'required',
            'comission_nom' => 'required'
        ];
    }

    
	public function attributes()
	{
		return [
			'name' => 'Nombre',
            'client_type_id' => 'Tipo de cliente'
		];
	}
}
