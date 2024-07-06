<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\AccountStatusDataTable;
use App\Http\Requests\AccountStatusRequest;
use App\Models\AccountStatus;

class AccountStatusController extends Controller
{
    public function index(AccountStatusDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("account_statuses.create");
        return $dataTable->render('account_statuses.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('account_statuses.create');
    }

    public function store(AccountStatusRequest $request)
    {
        $status = true;
		$account_status = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $account_status = AccountStatus::create($params);
            $message = "Tipo de estado creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'account_statuses');
		}
        return $this->getResponse($status, $message, $account_status);
    }

    
    public function edit(AccountStatus $account_status)
    {
        return view('account_statuses.edit', compact("account_status"));
    }

    
    public function update(AccountStatusRequest $request, AccountStatus $account_status)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $account_status->update($params);
            $message = "Tipo de estado modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'account_statuses');
        }
        return $this->getResponse($status, $message, $account_status);
    
    }

    public function destroy(AccountStatus $account_status)
    {
        $status = true;
        try {
            $account_status->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Tipo de estado desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'account_statuses');
        }
        return $this->getResponse($status, $message);
    }
}
