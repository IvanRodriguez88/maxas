<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CurrencyTypeDataTable;
use App\Http\Requests\CurrencyTypeRequest;
use App\Models\CurrencyType;

class CurrencyTypeController extends Controller
{
    public function index(CurrencyTypeDataTable $dataTable)
    {
        //obtener todos los roles, y permisos registrados
        $allowAdd = auth()->user()->hasPermissions("currency_types.create");
        return $dataTable->render('currency_types.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('currency_types.create');
    }

    public function store(CurrencyTypeRequest $request)
    {
        $status = true;
		$currency_type = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $currency_type = CurrencyType::create($params);
            $message = "Tipo de moneda creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'currency_types');
		}
        return $this->getResponse($status, $message, $currency_type);
    }

    
    public function edit(CurrencyType $currency_type)
    {
        return view('currency_types.edit', compact("currency_type"));
    }

    
    public function update(CurrencyTypeRequest $request, CurrencyType $currency_type)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $currency_type->update($params);
            $message = "Tipo de moneda modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'currency_types');
        }
        return $this->getResponse($status, $message, $currency_type);
    
    }

    public function destroy(CurrencyType $currency_type)
    {
        $status = true;
        try {
            $currency_type->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Tipo de moneda desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'currency_types');
        }
        return $this->getResponse($status, $message);
    }
}
