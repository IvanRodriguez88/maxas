<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\BankSeparationDataTable;
use App\Http\Requests\BankSeparationRequest;
use App\Models\BankSeparation;

class BankSeparationController extends Controller
{
    public function index(BankSeparationDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("bank_separations.create");
        return $dataTable->render('bank_separations.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('bank_separations.create');
    }

    public function store(BankSeparationRequest $request)
    {
        $status = true;
		$bank_separation = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $bank_separation = BankSeparation::create($params);
            $message = "Separación de banco creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'bank_separations');
		}
        return $this->getResponse($status, $message, $bank_separation);
    }

    
    public function edit(BankSeparation $bank_separation)
    {
        return view('bank_separations.edit', compact("bank_separation"));
    }

    
    public function update(BankSeparationRequest $request, BankSeparation $bank_separation)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $bank_separation->update($params);
            $message = "Separación de banco modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'bank_separations');
        }
        return $this->getResponse($status, $message, $bank_separation);
    
    }

    public function destroy(BankSeparation $bank_separation)
    {
        $status = true;
        try {
            $bank_separation->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Separación de banco desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'bank_separations');
        }
        return $this->getResponse($status, $message);
    }
}
