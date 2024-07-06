<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReturnTypeDataTable;
use App\Http\Requests\ReturnTypeRequest;
use App\Models\ReturnType;

class ReturnTypeController extends Controller
{
    public function index(ReturnTypeDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("return_types.create");
        return $dataTable->render('return_types.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('return_types.create');
    }

    public function store(ReturnTypeRequest $request)
    {
        $status = true;
		$return_type = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $return_type = ReturnType::create($params);
            $message = "Tipo de retorno creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_types');
		}
        return $this->getResponse($status, $message, $return_type);
    }

    
    public function edit(ReturnType $return_type)
    {
        return view('return_types.edit', compact("return_type"));
    }

    
    public function update(ReturnTypeRequest $request, ReturnType $return_type)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $return_type->update($params);
            $message = "Tipo de retorno modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_types');
        }
        return $this->getResponse($status, $message, $return_type);
    
    }

    public function destroy(ReturnType $return_type)
    {
        $status = true;
        try {
            $return_type->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Tipo de retorno desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_types');
        }
        return $this->getResponse($status, $message);
    }
}
