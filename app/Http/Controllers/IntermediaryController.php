<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\IntermediaryDataTable;
use App\Http\Requests\IntermediaryRequest;
use App\Models\Intermediary;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class IntermediaryController extends Controller
{
    public function index(IntermediaryDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("intermediaries.create");
        return $dataTable->render('intermediaries.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('intermediaries.create');
    }

    public function store(IntermediaryRequest $request)
    {
        $status = true;
		$intermediary = null;

        //Crear usuario
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 4,
        ]);

        $params = array_merge($request->all(), [
            "user_id" => $user->id,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $intermediary = Intermediary::create($params);
            $message = "Intermediario creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'intermediaries');
		}
        return $this->getResponse($status, $message, $intermediary);
    }

    
    public function edit(Intermediary $intermediary)
    {
        return view('intermediaries.edit', compact("intermediary"));
    }

    
    public function update(IntermediaryRequest $request, Intermediary $intermediary)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $intermediary->update($params);
            $intermediary->user->update(["email" => $params["email"]]);
            if ($request->password) {
                $intermediary->user->update(["password" => Hash::make($request->password)]);
            }
            $message = "Intermediario modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'intermediaries');
        }
        return $this->getResponse($status, $message, $intermediary);
    
    }

    public function destroy(Intermediary $intermediary)
    {
        $status = true;
        try {
            $intermediary->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Intermediario desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'intermediaries');
        }
        return $this->getResponse($status, $message);
    }
}
