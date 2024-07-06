<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\BankDataTable;
use App\Http\Requests\BankRequest;
use App\Models\Bank;

class BankController extends Controller
{
    public function index(BankDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("banks.create");
        return $dataTable->render('banks.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('banks.create');
    }

    public function store(BankRequest $request)
    {
        $status = true;
		$bank = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $bank = Bank::create($params);
            $message = "Banco creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'banks');
		}
        return $this->getResponse($status, $message, $bank);
    }

    
    public function edit(Bank $bank)
    {
        return view('banks.edit', compact("bank"));
    }

    
    public function update(BankRequest $request, Bank $bank)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $bank->update($params);
            $message = "Banco modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'banks');
        }
        return $this->getResponse($status, $message, $bank);
    
    }

    public function destroy(Bank $bank)
    {
        $status = true;
        try {
            $bank->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Banco desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'banks');
        }
        return $this->getResponse($status, $message);
    }
}
