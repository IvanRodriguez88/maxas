<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\DataTables\ReturnRequestDataTable;
use App\DataTables\ReturnRequestReturnTypeDataTable;
use App\DataTables\ReturnRequestConceptDataTable;
use App\DataTables\ClientReturnRequestDataTable;

use App\Http\Requests\ReturnRequestRequest;
use App\Models\ReturnRequest;
use App\Models\Company;
use App\Models\Client;
use App\Models\ReturnBase;
use App\Models\Promotor;
use App\Models\Bank;
use App\Models\ReturnType;
use App\Models\ReturnRequestReturnType;
use App\Models\ReturnRequestStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentWay;
use App\Models\CfdiUse;
use App\Models\UnitType;
use App\Models\ReturnRequestConcept;
use App\Models\RequestType;
use App\Models\ClientBusiness;
use App\Models\Account;



class ReturnRequestController extends Controller
{

    public function new()
    {
        return view('return_requests.create', $this->getCommonModels());
    }

    public function index()
    {
        $user = auth()->user();
        if ($user->role_id == 2) {
            $dataTable = new ClientReturnRequestDataTable();
            $allowAdd = $user->hasPermissions("return_requests.create");
            $allowAdd = true;
            return $dataTable->render('client_portal.dashboard.index', compact("allowAdd"));
        }else{
            $dataTable = new ReturnRequestDataTable();
            $returnRequestStatuses = ReturnRequestStatus::where("is_active", 1)->pluck("name", "id");
            // $allowAdd = auth()->user()->hasPermissions("return_requests.create");
            $allowAdd = false;
            return $dataTable->render('return_requests.index', compact("allowAdd", "returnRequestStatuses"));
        }

    }

    private function getCommonModels()
    {
        $client = Client::where("user_id", auth()->user()->id)->first();
        $lastId = ReturnRequest::max('id');
        $paymentMethods = PaymentMethod::where('is_active', 1)->selectRaw("id, CONCAT(name, ' - ', description) as name")->pluck('name', 'id');
        $paymentWays = PaymentWay::where("is_active", 1)->pluck("name", "id");
        $requestTypes = RequestType::where("is_active", 1)->pluck("name", "id");

        $companies = $client->companies->where("is_active")->pluck("name", "id");

        //Verificar si el cliente es persona fisica o moral ------------- 1 = fisica 2 = moral
        if ($client->client_type_id == 1) {
            $clientType = "physical_person";
        }else if ($client->client_type_id == 2) {
            $clientType = "moral_person";
        }

        $cfdiUses = CfdiUse::where("is_active", 1)
                    ->select(DB::raw("CONCAT(code, ' - ', name) as name"), 'id')
                    ->where($clientType, 1)
                    ->pluck('name', 'id');

        return compact("client", "lastId", "paymentMethods", "paymentWays", "cfdiUses", "companies", "requestTypes");
    }

    public function create()
    {
        return view('return_requests.create', $this->getCommonModels());
    }

    public function store(Request $request)
    {
        $status = true;
		$return_request = null;
        //Buscar cliente
        $client = ClientBusiness::find($request->client_business_id)->client ?? null;
        
        if ($client != null) {
            //Buscar porcentaje de retorno en base al tipo de solicitud elegido
            $request_type_id = $request->request_type_id;
            $return_percentages = $this->getReturnPercentages($client, $request_type_id);
        }
        
        $company = Company::find($request->company_id);
        
        $params = array_merge($request->all(), [
            'is_active' => 1,
            'date' => now(),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'return_base_id' => $client->return_base_id ?? null,
            'return_percentage' => $return_percentages["total"] ?? null,
            'return_percentage_play' => ($return_percentages["play"] ?? 0 - ($company->intermediary->comission_percentage ?? 0)) ,
            'return_percentage_promotor' => $return_percentages["promotor"] ?? null,
            'intermediary_id' =>  $company->intermediary->id ?? null,
            'return_percentage_intermediary' => $company->intermediary->comission_percentage ?? 0,
            'requires_invoice' => !is_null($request->requires_invoice),
		]);

		try {
            $return_request = ReturnRequest::create($params);
            $message = "Solicitud de retorno creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_requests'); 
		}
        return $this->getResponse($status, $message, $return_request, redirect()->route("return_requests.edit", $return_request->id));
    } 


    
    public function edit(ReturnRequest $return_request)
    {
        // return view("return_requests.cab-mail", compact("return_request"));

        $returnRequestReturnTypeDataTable = new ReturnRequestReturnTypeDataTable($return_request->id);
        $params = ['return_request' => $return_request->id];
        $returnRequestReturnTypeDT = $this->getViewDataTable($returnRequestReturnTypeDataTable, 'return_requests', [], 'return_requests.getReturnRequestReturnTypeDataTable', $params);
        
        $returnRequestConceptDataTable = new ReturnRequestConceptDataTable($return_request->id);
        $params = ['return_request' => $return_request->id];
        $returnRequestConceptDT = $this->getViewDataTable($returnRequestConceptDataTable, 'return_requests', [], 'return_requests.getReturnRequestConceptDataTable', $params);
        
        return view('return_requests.edit', array_merge(compact("return_request", "returnRequestReturnTypeDT", "returnRequestConceptDT")), $this->getCommonModels());
    }

    
    public function update(Request $request, ReturnRequest $return_request)
    {
        $status = true;
        $file = $request->file("client_payment_proof");
        $return_status = 1; //Default incompleta


        //Verificar que exista al menos 1 forma de retorno y 1 concepto y que tenga el comprobante de pago
        if ($return_request->returnConcepts->count() > 0 && $return_request->returnTypes->count() > 0) {
            $return_status = 2; //Por operar
        }

        $params = array_merge($request->all(), [
            'requires_invoice' => !is_null($request->requires_invoice),
            'return_request_status_id' => $return_status,
            "updated_by" => auth()->user()->id,
		]);

        if ($file) {
            $filePath = $file->storeAs(
                '',
                'SR'.$return_request->id.'-comprobante_pago_cliente'.".".$file->extension(),
                'client_payment_proofs'
            );
            $params['client_payment_proof'] = $filePath;
        }

        try {
            $return_request->update($params);
            // $this->sendCabMail($return_request);
            $message = "Solicitud de retorno modificado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_requests');
        }
        return $this->getResponse($status, $message, $return_request);
    
    }

    public function destroy(ReturnRequest $return_request)
    {
        $status = true;
        try {
            $return_request->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Solicitud de retorno desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_requests');
        }
        return $this->getResponse($status, $message);
    }

    public function show(ReturnRequest $return_request) 
    {
        $user = auth()->user();
        $view = "return_requests.show_admin";
        switch ($user->role_id) {
            case 2:
                $view = "return_requests.show_client";
                break;
            case 5:
                if ($return_request->return_request_status_id == 6) { //Si ya fue operada, operaciones ve la vista terminada
                    $view = "return_requests.show_operadas";
                }else{
                    $view = "return_requests.show_operaciones";
                }
                break;
            case 6:
                $view = "return_requests.show_ingresos";
                break;
            case 7:
                $view = "return_requests.show_mesa_control";
                break;
             case 8:
                $view = "return_requests.show_egresos";
                $returnRequestReturnTypeDataTable = new ReturnRequestReturnTypeDataTable($return_request->id);
                $params = ['return_request' => $return_request->id];
                $returnRequestReturnTypeDT = $this->getViewDataTable($returnRequestReturnTypeDataTable, 'return_requests', [], 'return_requests.getReturnRequestReturnTypeDataTable', $params);
				$companies = Company::where('company_level_id', 3)->where("is_active", 1)->get();
				$accounts = $companies->where("is_active", 1)->flatMap(function($company) {
					return $company->accounts;
				});
                return view($view, compact("return_request", "returnRequestReturnTypeDT", "accounts"));
                break;
        }
        return view($view, compact("return_request"));
     
    }

    public function getAddReturnTypeModal()
    {
        $banks = Bank::where("is_active", 1)->orderBy("name", "asc")->pluck("name", "id");
        $returnTypes = ReturnType::where("is_active", 1)->pluck("name", "id");
        $type = "add";
        return view("return_requests.modal-content", compact("banks", "returnTypes", "type"));
    }

    public function getEditReturnTypeModal(ReturnRequestReturnType $return_request_return_type)
    {
        $banks = Bank::where("is_active", 1)->orderBy("name", "asc")->pluck("name", "id");
        $returnTypes = ReturnType::where("is_active", 1)->pluck("name", "id");
        $type = "edit";
        return view("return_requests.modal-content", compact("banks", "returnTypes", "type", "return_request_return_type"));
    }

    public function addReturnRequestType(Request $request)
    {
        $status = true;
		$return_type = null;
        $params = array_merge($request->all(), [
            'is_active' => true,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);

		try {
            $return_request_return_type = ReturnRequestReturnType::create($params);
            $return_request = ReturnRequest::find($return_request_return_type->return_request_id);
            $message = "Forma de retorno creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_types');
		}
        return $this->getResponse($status, $message, $return_request);

    }

    public function editReturnRequestType(Request $request, ReturnRequestReturnType $return_request_return_type) 
    {
        $status = true;
        $params = array_merge($request->all(), [
            'updated_by' => auth()->user()->id,
		]);

		try {
            $return_request_return_type->update($params);
            $message = "Forma de retorno creado correctamente";
            $return_request = ReturnRequest::find($return_request_return_type->return_request_id);
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_types');
		}
        return $this->getResponse($status, $message, $return_request);
    }

    public function deleteReturnRequestType(ReturnRequestReturnType $return_request_return_type)
    {
        $status = true;
        try {
            $return_request_return_type->delete();
            $message = "Forma de retorno eliminada correctamente";
            $return_request = ReturnRequest::find($return_request_return_type->return_request_id);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_requests');
        }
        return $this->getResponse($status, $message, $return_request);
    }


    //------------------------CONCEPTOS---------------------------------


    public function getEditReturnConceptModal(ReturnRequestConcept $return_request_concept)
    {
        $type = "edit";
        $unitTypes = UnitType::where('is_active', 1)->selectRaw("id, CONCAT(code, ' - ', name) as name")->pluck('name', 'id');
        return view("return_requests.modal-content-concept", compact("type", "return_request_concept", "unitTypes"));
    }

    public function getAddReturnConceptModal()
    {
        $type = "add";
        $unitTypes = UnitType::where('is_active', 1)->selectRaw("id, CONCAT(code, ' - ', name) as name")->pluck('name', 'id');
        return view("return_requests.modal-content-concept", compact("type", "unitTypes"));
    }

    public function addReturnRequestConcept(Request $request)
    {
        $status = true;
		$return_concept = null;
        $subtotalReturnRequest = 0;
        $params = array_merge($request->all(), [
            'is_active' => true,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'total' => $request->amount * $request->unit_price
		]);
		try {
            $return_concept = ReturnRequestConcept::create($params);
            $message = "Concepto creado correctamente";
            $return_request = $this->updateNumericValues($return_concept->return_request_id);
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_concepts');
		}
        return $this->getResponse($status, $message, $return_request);

    }

    public function editReturnRequestConcept(Request $request, ReturnRequestConcept $return_request_concept) 
    {
        $status = true;
        $params = array_merge($request->all(), [
            'updated_by' => auth()->user()->id,
            'total' => $request->amount * $request->unit_price
		]);

		try {
            $return_request_concept->update($params);
            $message = "Concepto editado correctamente";
            $return_request = $this->updateNumericValues($return_request_concept->return_request_id);
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_types');
		}
        return $this->getResponse($status, $message, $return_request);
    }

    public function deleteReturnRequestConcept(ReturnRequestConcept $return_request_concept)
    {
        $status = true;
        try {
            $return_request_concept->delete();
            $message = "Concepto eliminado correctamente";
            $return_request = $this->updateNumericValues($return_request_concept->return_request_id);
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_requests');
        }
        return $this->getResponse($status, $message, $return_request);
    }

    //------------------------Dispersion vouchers---------------------------------

    public function getAddDispersionVoucherFileModal(ReturnRequestReturnType $return_request_return_type)
    {
        return view("return_requests.modal-content-egresos", compact("return_request_return_type"));
    }

    public function addDispersionVoucherFile(Request $request, ReturnRequestReturnType $return_request_return_type)
    {
        $status = false;
        $file = $request->file("dispersion_voucher_file");
		$account_id = $request->account_id;
        $message = "No se cargó el comprobante";
		$return_request = ReturnRequest::find($return_request_return_type->return_request_id);

		
		if ($account_id != "null") {
			$account = Account::find($account_id);
			if ($account->balance - $return_request_return_type->amount > 0) {
				if ($file) {
					$filePath = $file->storeAs(
						'',
						'SR'.$return_request->id.'-comprobante_dispersion'.$return_request_return_type->id.".".$file->extension(),
						'dispersion_voucher_files'
					);
					$params['dispersion_voucher_file'] = $filePath;
					$params['account_id'] = $account->id;
					try {
						$return_request_return_type->update($params);
						$account->update(["balance" => $account->balance - $return_request_return_type->amount]);
						$message = "Dispersión y comprobante cargado correctamente";
						$status = true;
					} catch (\Illuminate\Database\QueryException $e) {
						$status = false;
						$message = $this->getErrorMessage($e, 'return_requests');
					}
				}
			}else{
				$message = "No se puede dispersar, faltan $". number_format(abs($account->balance - $return_request_return_type->amount), 2, '.', ',');
			}
		}else{
			$message = "No se seleccionó una cuenta";
		}

       
        return $this->getResponse($status, $message, $return_request);
    }

    public function addInvoice(Request $request, ReturnRequest $return_request)
    {
        $status = false;
        $file = $request->file("invoice");
        $message = "No se cargó la factura";
        if ($file) {
            $filePath = $file->storeAs(
                '',
                'SR'.$return_request->id.'-factura'.".".$file->extension(),
                'invoices'
            );
            $params['invoice'] = $filePath;

            try {
                $return_request->update($params);
                $message = "Factura cargada correctamente";
                $status = true;
            } catch (\Illuminate\Database\QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'return_requests');
            }
        }
       
        return $this->getResponse($status, $message, $return_request);
    }

    public function addClientPaymentProof(Request $request, ReturnRequest $return_request)
    {
        $status = false;
        $file = $request->file("client_payment_proof");
        $message = "No se cargó el comprobante de pago";
        if ($file) {
            $filePath = $file->storeAs(
                '',
                'SR'.$return_request->id.'-comprobante_pago_cliente'.".".$file->extension(),
                'client_payment_proofs'
            );
            $params['client_payment_proof'] = $filePath;

            try {
                $return_request->update($params);
                $message = "Comprobante de pago cargado correctamente";
                $status = true;
            } catch (\Illuminate\Database\QueryException $e) {
                $status = false;
                $message = $this->getErrorMessage($e, 'return_requests');
            }
        }
       
        return $this->getResponse($status, $message, $return_request);
    }


    public function getReturnRequestReturnTypeDataTable(ReturnRequest $return_request)
    {
        return (new ReturnRequestReturnTypeDataTable($return_request->id))->render('components.datatable');
    }

    public function getReturnRequestConceptDataTable(ReturnRequest $return_request)
    {
        return (new ReturnRequestConceptDataTable($return_request->id))->render('components.datatable');
    }

    public function downloadClientPaymentProof(ReturnRequest $return_request)
    {
        $path = $return_request->client_payment_proof;
        $mimeType = Storage::disk('client_payment_proofs')->mimeType($path);
        $fileContent = Storage::disk('client_payment_proofs')->get($path);

        // Devolver la respuesta con el contenido del archivo y los encabezados adecuados
        return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="'.basename($path).'"');
    }

    public function downloadBankPaymentProof(ReturnRequest $return_request)
    {
        $path = $return_request->bank_payment_proof;
        $mimeType = Storage::disk('bank_payment_proofs')->mimeType($path);
        $fileContent = Storage::disk('bank_payment_proofs')->get($path);

        // Devolver la respuesta con el contenido del archivo y los encabezados adecuados
        return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="'.basename($path).'"');
    }

    public function downloadDispersionVoucherFile(ReturnRequestReturnType $return_request_return_type)
    {
        $path = $return_request_return_type->dispersion_voucher_file;
        $mimeType = Storage::disk('dispersion_voucher_files')->mimeType($path);
        $fileContent = Storage::disk('dispersion_voucher_files')->get($path);

        // Devolver la respuesta con el contenido del archivo y los encabezados adecuados
        return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="'.basename($path).'"');
    }

    public function downloadInvoice(ReturnRequest $return_request)
    {
        $path = $return_request->invoice;
        $mimeType = Storage::disk('invoices')->mimeType($path);
        $fileContent = Storage::disk('invoices')->get($path);

        // Devolver la respuesta con el contenido del archivo y los encabezados adecuados
        return response($fileContent, 200)
                ->header('Content-Type', $mimeType)
                ->header('Content-Disposition', 'inline; filename="'.basename($path).'"');
    }
    

    public function changeStatus(ReturnRequest $return_request, $status_id)
    {
        $return_request->update([
            "return_request_status_id" => $status_id,
        ]);

        return $return_request;
    }

    public function updateIngresos(Request $request, ReturnRequest $return_request)
    {
        $status = false;
        $file = $request->file("bank_payment_proof");
        if ($file) {
            $filePath = $file->storeAs(
                '',
                'SR'.$return_request->id.'-comprobante_pago_banco'.".".$file->extension(),
                'bank_payment_proofs'
            );

            $params['bank_payment_proof'] = $filePath;
            $params["updated_by"] = auth()->user()->id;
            $params["return_request_status_id"] = 4; //4 es mesa de control

            $status = true;
            $return_request->update($params);
			$return_request->account->update(["balance" => $return_request->account->balance + $return_request->total_invoice]);
			
        }

        return $this->getResponse($status, '', $return_request);
    }

    public function updateMesaControl(ReturnRequest $return_request)
    {
        $status = true;
        $params["updated_by"] = auth()->user()->id;
        $params["return_request_status_id"] = 5; //5 es egresos
        $return_request->update($params);
        return $this->getResponse($status, '', $return_request);
    }

    public function updateEgresos(ReturnRequest $return_request)
    {
        $status = true;
        $params["updated_by"] = auth()->user()->id;
        $params["return_request_status_id"] = 6; //5 es operada o finalizada
        $return_request->update($params);
        return $this->getResponse($status, '', $return_request);
    }


    public function sendCabMail(ReturnRequest $return_request)
    {
        $path = $return_request->client_payment_proof;
        $fileContent = Storage::disk('client_payment_proofs')->get($path);
        $fileName = basename($path);
        $mimeType = Storage::disk('client_payment_proofs')->mimeType($path);

        $subject = 'Solicitud de retorno - '.$return_request->id;
        $attachments = [
            [
                'data' => $fileContent,
                'name' => $fileName,
                'options' => [
                    'mime' => $mimeType,
                ]
            ],
        ];
        $data = ['return_request' => $return_request];
    
        Mail::send('return_requests.cab-mail', $data, function ($message) use ($attachments, $subject) {
            $message->to('destinatario@ejemplo.com')
                    ->subject($subject);
    
            foreach ($attachments as $attachment) {
                $message->attachData($attachment['data'], $attachment['name'], $attachment['options']);
            }
        });    
    }

    function getReturnPercentages(Client $client, $request_type_id){
       

        switch ($request_type_id) {
            case '1':
                $return_percentage_total = $client->comission_ban;
                break;
            case '2':
                $return_percentage_total = $client->comission_flu;
                break;
            case '3':
                $return_percentage_total = $client->comission_nom;
                break;
            default:
                $return_percentage_total = 0;
                break;
        }

        $return_percentage_promotor = 0;
        //Comprobar si el cliente es de un promotor
        if ($client->promotor != null) {
            switch ($request_type_id) {
                case '1':
                    $return_percentage_promotor = $client->comission_ban_promotor;
                    break;
                case '2':
                    $return_percentage_promotor = $client->comission_flu_promotor;
                    break;
                case '3':
                    $return_percentage_promotor = $client->comission_nom_promotor;
                    break;
                default:
                    break;
            }
        }

        return $return_percentages = [
            "total" => $return_percentage_total,
            "play" => $return_percentage_total - $return_percentage_promotor,
            "promotor" => $return_percentage_promotor
        ];
        
    }

    //Actualiza comisiones, subtotal, iva y total de una return request
    function updateNumericValues($return_request_id){
        $return_request = ReturnRequest::find($return_request_id);
        $subtotal = ReturnRequestConcept::where("return_request_id", $return_request->id)->sum("total");

        $iva = $subtotal * 0.16;
        $total = $subtotal + $iva;


        $base_total = $total; //Por default sobre el total
        //Revisar base de retorno
        if ($return_request->return_base_id == 2) { //Si es sobre subtotal
            $base_total = $subtotal;
        }
        //Calcular comision de play
        $comission_play = ($base_total * $return_request->return_percentage_play) / 100;
        $comission_promotor = ($base_total * $return_request->return_percentage_promotor) / 100;
        $comission_intermediary = 0;

        //Si caballero es intermediario cobrar el .05 sobre total
        if ($return_request->intermediary_id != null) { 
            $comission_intermediary = ($total * $return_request->return_percentage_intermediary) / 100;
        }

        //La comision si hay de caballero se le resta a la de play
        $comission_charged = $comission_play + $comission_promotor + $comission_intermediary;

        //Cuando es de caballero esto es lo que debe regresar caballero a play
        $play_return = $total - $comission_intermediary; 

        $total_return = $total - $comission_charged;

        $return_request->update([
            'subtotal' => $subtotal, 
            'iva' => $iva, 
            'total_invoice' => $total, 
            'comission_charged'=> $comission_charged, 
            'comission_play'=> $comission_play, 
            'comission_promotor'=> $comission_promotor, 
            'comission_intermediary'=> $comission_intermediary, 
            'social_cost'=> 0,
            'total_return'=> $total_return,
            'play_return'=> $play_return,
        ]);
        return $return_request;

    }

}
