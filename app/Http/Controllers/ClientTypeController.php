<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ClientTypeDataTable;
use App\Http\Requests\ClientTypeRequest;
use App\Models\ClientType;

class ClientTypeController extends Controller
{
    public function index(ClientTypeDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("client_types.create");
        return $dataTable->render('client_types.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('client_types.create');
    }

    public function store(ClientTypeRequest $request)
    {
        $status = true;
		$client_type = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $client_type = ClientType::create($params);
            $message = "Banco creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'client_types');
		}
        return $this->getResponse($status, $message, $client_type);
    }

    
    public function edit(ClientType $client_type)
    {
        return view('client_types.edit', compact("client_type"));
    }

    
    public function update(ClientTypeRequest $request, ClientType $client_type)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $client_type->update($params);
            $message = "Banco modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'client_types');
        }
        return $this->getResponse($status, $message, $client_type);
    
    }

    public function destroy(ClientType $client_type)
    {
        $status = true;
        try {
            $client_type->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Banco desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'client_types');
        }
        return $this->getResponse($status, $message);
    }
}
