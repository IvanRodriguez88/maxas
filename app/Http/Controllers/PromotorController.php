<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\PromotorDataTable;
use App\DataTables\PromotorClientDataTable;

use App\Http\Requests\PromotorRequest;
use App\Models\Promotor;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PromotorController extends Controller
{
    public function index(PromotorDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("promotors.create");
        return $dataTable->render('promotors.index', compact("allowAdd"));
    }

    public function create()
    {
        return view('promotors.create');
    }

    public function store(PromotorRequest $request)
    {
        $status = true;
		$promotor = null;

        //Crear usuario
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 3,
        ]);


        $params = array_merge($request->all(), [
            "user_id" => $user->id,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $promotor = Promotor::create($params);
            $message = "Promotor creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'promotors');
		}
        return $this->getResponse($status, $message, $promotor);
    }

    
    public function edit(Promotor $promotor)
    {
        return view('promotors.edit', compact("promotor"));
    }

    public function show(Promotor $promotor)
    {
        $allowAdd = auth()->user()->hasPermissions("promotor_clients.store");
        $dataTable = new PromotorClientDataTable($promotor->id);
        return $dataTable->render('promotors.show', compact("promotor", "allowAdd"));
    }
    
    public function update(PromotorRequest $request, Promotor $promotor)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);
        unset($params["password"]);
        try {
            $promotor->update($params);
            $promotor->user->update(["email" => $params["email"]]);
            if ($request->password) {
                $promotor->user->update(["password" => Hash::make($request->password)]);
            }
            $message = "Promotor modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'promotors');
        }
        return $this->getResponse($status, $message, $promotor);
    
    }

    public function destroy(Promotor $promotor)
    {
        $status = true;
        try {
            $promotor->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Promotor desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'promotors');
        }
        return $this->getResponse($status, $message);
    }

    public function getAddPromotorClientModal()
    {
        $type = "add";
        return view("promotors.modal-content", compact("type"));
    }
}
