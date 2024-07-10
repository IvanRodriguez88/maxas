<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ClientDataTable;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\User;
use App\Models\Company;
use App\Models\Promotor;
use App\Models\ReturnBase;

use Illuminate\Support\Facades\Hash;

use App\Models\ClientType;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index(ClientDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("clients.create");
        return $dataTable->render('clients.index', compact("allowAdd"));
    }

    private function getCommonModels()
    {
        $clientTypes = ClientType::where("is_active", 1)->pluck("name", "id");
        $companies = Company::where("is_active", 1)->get();
        $promotors = Promotor::where("is_active", 1)->pluck("name", "id");
        $returnBases = ReturnBase::where("is_active", 1)->pluck("name", "id");
        return compact("clientTypes", "companies", "promotors", "returnBases");
    }

    public function create()
    {
        return view('clients.create', $this->getCommonModels());
    }

    public function store(ClientRequest $request)
    {
        $status = true;
		$client = null;

        //Crear usuario
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2,
        ]);


        $params = array_merge($request->all(), [
            "user_id" => $user->id,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);

        if ($params["promotor_id"] == null) {
            $params["comission_ban_promotor"] = null;
            $params["comission_flu_promotor"] = null;
            $params["comission_nom_promotor"] = null;
        }

		try {
            $client = Client::create($params);
            $client->companies()->attach($params["companies"] ?? []);
            $message = "Cliente creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'clients');
		}
        return $this->getResponse($status, $message, $client);
    }

    
    public function edit(Client $client)
    {
        return view('clients.edit', array_merge($this->getCommonModels(), compact('client')));
    }

    
    public function update(ClientRequest $request, Client $client)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        unset($params["password"]);

        if ($params["promotor_id"] == null) {
            $params["comission_ban_promotor"] = null;
            $params["comission_flu_promotor"] = null;
            $params["comission_nom_promotor"] = null;
        }

        try {
            $client->update($params);
            $client->companies()->sync($params["companies"] ?? []);
            $client->user->update(["email" => $params["email"]]);
            if ($request->password) {
                $client->user->update(["password" => Hash::make($request->password)]);
            }
            $message = "Cliente modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'clients');
        }
        return $this->getResponse($status, $message, $client);
    
    }

    public function destroy(Client $client)
    {
        $status = true;
        try {
            $client->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Cliente desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'clients');
        }
        return $this->getResponse($status, $message);
    }

    public function getDataAutocomplete()
    {
        $clients = Client::select(
            "id",
            DB::raw("clients.name as name")
        )->get();

        $formattedClients = $clients->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->name
            ];
        });

        return response()->json($formattedClients);    
    }
}
