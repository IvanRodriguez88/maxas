<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\ClientDataTable;
use App\DataTables\ClientBusinessDataTable;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\User;
use App\Models\Company;
use App\Models\Promotor;
use App\Models\ReturnBase;
use App\Models\ClientBusiness;

use Illuminate\Support\Facades\Hash;

use App\Models\ClientType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        if (!isset($params["promotor_id"])) {
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
        return $this->getResponse($status, $message, $client, redirect()->route('clients.edit', $client->id));
    }

    
    public function edit(Client $client)
    {
        $clientBusinessDataTable = new ClientBusinessDataTable($client->id);
        $params = ['client' => $client->id];
        $clientBusinessDT = $this->getViewDataTable($clientBusinessDataTable, 'clients', [], 'clients.getClientBusinessDataTable', $params);

        return view('clients.edit', array_merge($this->getCommonModels(), compact('client', 'clientBusinessDT')));
    }

    
    public function update(ClientRequest $request, Client $client)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        unset($params["password"]);
        if (!isset($params["promotor_id"])) {
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

    public function getAddClientBusinessModal()
    {
        $type = "add";
        return view("clients.modal-content", compact("type"));
    }

    public function getEditClientBusinessModal(ClientBusiness $client_business)
    {
        $type = "edit";
        return view("clients.modal-content", compact("client_business", "type"));
    }

    public function addClientBusiness(Request $request, Client $client)
    {
        $status = true;
		$client_business = null;
        $params = array_merge($request->all(), [
            'is_active' => true,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);

        $file = $request->file("file");
        
		try {
            $client_business = ClientBusiness::create($params);

            if ($file) {
                $filePath = $file->storeAs(
                    '',
                    'CF-'.$client_business->id."-".$client_business->business_name.".".$file->extension(),
                    'business_files'
                );
                $params['file'] = $filePath;
                $client_business->update(["file" => $filePath]);
            }

            $message = "Razón social creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'clients');
		}
        return $this->getResponse($status, $message, $client_business);

    }

    public function editClientBusiness(Request $request, ClientBusiness $client_business) 
    {
        $status = true;
        $params = array_merge($request->all(), [
            'updated_by' => auth()->user()->id,
		]);
        $file = $request->file("file");

        if ($file) {
            $filePath = $file->storeAs(
                '',
                'CF-'.$client_business->id."-".$client_business->business_name.".".$file->extension(),
                'business_files'
            );
            $params['file'] = $filePath;
        }

		try {
            $client_business->update($params);
            $message = "Razón social modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'clients');
		}
        return $this->getResponse($status, $message, $client_business);
    }

    public function deleteClientBusiness(ClientBusiness $client_business)
    {
        $status = true;
        try {
            $client_business->delete();
            $message = "Razón social eliminada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'clients');
        }
        return $this->getResponse($status, $message);
    }

    public function downloadBusinessFile(ClientBusiness $client_business)
    {
        $path = $client_business->file;
        $mimeType = Storage::disk('business_files')->mimeType($path);
        $fileContent = Storage::disk('business_files')->get($path);

        // Devolver la respuesta con el contenido del archivo y los encabezados adecuados
        return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="'.basename($path).'"');
    }

    public function getClientBusinessDataById(ClientBusiness $client_business)
    {
        return response()->json($client_business);    
    }

    public function getClientBusinessDataTable(Client $client)
    {
        return (new ClientBusinessDataTable($client->id))->render('components.datatable');
    }
}
