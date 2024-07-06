<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ReturnBaseDataTable;
use App\Http\Requests\ReturnBaseRequest;
use App\Models\ReturnBase;

class ReturnBaseController extends Controller
{
    public function index(ReturnBaseDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("return_bases.create");
        return $dataTable->render('return_bases.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('return_bases.create');
    }

    public function store(ReturnBaseRequest $request)
    {
        $status = true;
		$return_base = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $return_base = ReturnBase::create($params);
            $message = "Base de retorno creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_bases');
		}
        return $this->getResponse($status, $message, $return_base);
    }

    
    public function edit(ReturnBase $return_base)
    {
        return view('return_bases.edit', compact("return_base"));
    }

    
    public function update(ReturnBaseRequest $request, ReturnBase $return_base)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $return_base->update($params);
            $message = "Base de retorno modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_bases');
        }
        return $this->getResponse($status, $message, $return_base);
    
    }

    public function destroy(ReturnBase $return_base)
    {
        $status = true;
        try {
            $return_base->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Base de retorno desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_bases');
        }
        return $this->getResponse($status, $message);
    }
}
