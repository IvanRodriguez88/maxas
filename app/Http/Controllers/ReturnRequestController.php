<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\DataTables\ReturnRequestDataTable;
use App\DataTables\ReturnRequestReturnTypeDataTable;
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

class ReturnRequestController extends Controller
{

    public function new()
    {
        return view('return_requests.create', $this->getCommonModels());
    }

    public function index(ReturnRequestDataTable $dataTable)
    {
        $returnRequestStatuses = ReturnRequestStatus::where("is_active", 1)->pluck("name", "id");
        $allowAdd = auth()->user()->hasPermissions("return_requests.create");
        return $dataTable->render('return_requests.index', compact("allowAdd", "returnRequestStatuses"));
    }

    private function getCommonModels()
    {
        $companies = Company::where("is_active", 1)->pluck("name", "id");
        $clients = Client::where("is_active", 1)->pluck("name", "id");
        $returnBases = ReturnBase::where("is_active", 1)->pluck("name", "id");
        $promotors = Promotor::where("is_active", 1)->pluck("name", "id");
        $lastId = ReturnRequest::max('id');
        return compact("companies", "clients", "lastId", "returnBases", "promotors");
    }

    public function create()
    {
        return view('return_requests.create', $this->getCommonModels());
    }

    public function store(ReturnRequestRequest $request)
    {
        $status = true;
		$return_request = null;
        $params = array_merge($request->all(), [
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);

        foreach ($params as $key => $param) {
            if ($param == null) {
                $params[$key] = 10;
            }
        }

		try {
            $return_request = ReturnRequest::create($params);

            $file = $request->file("client_payment_proof");
            $filePath = $file->storeAs(
                '',
                'SR'.$return_request->id.'-comprobante_pago_cliente'.".".$file->extension(),
                'client_payment_proofs'
            );
            
            $return_request->update(["client_payment_proof" => $filePath]);
            $message = "Solicitud de retorno creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_requests');
		}
        return $this->getResponse($status, $message, $return_request);
    }

    
    public function edit(ReturnRequest $return_request)
    {
        // return view("return_requests.cab-mail", compact("return_request"));

        $returnRequestReturnTypeDataTable = new ReturnRequestReturnTypeDataTable($return_request->id);
        $params = ['return_request' => $return_request->id];
        $returnRequestReturnTypeDT = $this->getViewDataTable($returnRequestReturnTypeDataTable, 'return_requests', [], 'return_requests.getReturnRequestReturnTypeDataTable', $params);
        return view('return_requests.edit', array_merge(compact("return_request", "returnRequestReturnTypeDT")), $this->getCommonModels());
    }

    
    public function update(ReturnRequestRequest $request, ReturnRequest $return_request)
    {
        $status = true;
        $file = $request->file("client_payment_proof");

        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
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
            $this->sendCabMail($return_request);
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

    public function getAddReturnTypeModal()
    {
        $banks = Bank::where("is_active", 1)->pluck("name", "id");
        $returnTypes = ReturnType::where("is_active", 1)->pluck("name", "id");
        $type = "add";
        return view("return_requests.modal-content", compact("banks", "returnTypes", "type"));
    }

    public function getEditReturnTypeModal(ReturnRequestReturnType $return_request_return_type)
    {
        $banks = Bank::where("is_active", 1)->pluck("name", "id");
        $returnTypes = ReturnType::where("is_active", 1)->pluck("name", "id");
        $type = "edit";
        return view("return_requests.modal-content", compact("banks", "returnTypes", "type", "return_request_return_type"));
    }

    public function addReturnRequestType(Request $request, ReturnRequest $return_request)
    {
        $status = true;
		$return_type = null;
        $params = array_merge($request->all(), [
            'is_active' => true,
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);

		try {
            $return_type = ReturnRequestReturnType::create($params);
            $message = "Forma de retorno creado correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_types');
		}
        return $this->getResponse($status, $message, $return_type);

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
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_types');
		}
        return $this->getResponse($status, $message, $return_request_return_type);
    }

    public function deleteReturnRequestType(ReturnRequestReturnType $return_request_return_type)
    {
        $status = true;
        try {
            $return_request_return_type->delete();
            $message = "Forma de retorno eliminada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'return_requests');
        }
        return $this->getResponse($status, $message);
    }

    public function getReturnRequestReturnTypeDataTable(ReturnRequest $return_request)
    {
        return (new ReturnRequestReturnTypeDataTable($return_request->id))->render('components.datatable');
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

}
