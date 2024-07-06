<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ClientDataTable;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\User;
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
        return compact("clientTypes");
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
            "name" => $request->name,
            "user_id" => $user->id,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $client = Client::create($params);
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
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $client->update($params);
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
