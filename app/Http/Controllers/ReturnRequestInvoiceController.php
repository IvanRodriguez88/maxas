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
use App\DataTables\ReturnRequestInvoiceDataTable;

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
use App\Models\ReturnRequestInvoice;

class ReturnRequestInvoiceController extends Controller
{
    public function index(ReturnRequest $return_request)
    {
        $user = auth()->user();
        $allowAdd = $user->hasPermissions("return_requests.create");

        $returnRequestInvoiceDatatable = new ReturnRequestInvoiceDataTable($return_request->id);
        $params = ['return_request' => $return_request->id];
        $returnRequestInvoiceDT = $this->getViewDataTable($returnRequestInvoiceDatatable, 'return_request_invoices', [], 'return_request_invoices.getReturnRequestInvoiceDataTable', $params);
        return view('return_request_invoices.index', compact("return_request", "returnRequestInvoiceDT", "allowAdd"));
    }

    public function create(ReturnRequest $return_request)
    {
        return view('return_request_invoices.create', array_merge(compact("return_request"), $this->getCommonModels()));
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
            'client_business_id' => $request->client_business_id ?? null,
            'promotor_id' => $client->promotor_id ?? null,
            'subtotal' => 0, 
            'iva' => 0, 
            'total_invoice' => 0, 
            'requires_invoice' => !is_null($request->requires_invoice),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
            'is_active' => 1,
		]); 
        
		try {
            $return_request_invoice = ReturnRequestInvoice::create($params);
            $message = "Factura creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'return_request_invoice'); 
		}
        return $this->getResponse($status, $message, $return_request_invoice, redirect()->route("return_request_invoices.index", $return_request_invoice->return_request_id));
    } 

    public function edit(ReturnRequestInvoice $return_request_invoice)
    {
        // return view("return_requests.cab-mail", compact("return_request"));
        $returnRequestReturnTypeDataTable = new ReturnRequestReturnTypeDataTable($return_request_invoice->id);
        $params = ['return_request_invoice' => $return_request_invoice->id];
        $returnRequestReturnTypeDT = $this->getViewDataTable($returnRequestReturnTypeDataTable, 'return_request_invoices', [], 'return_request_invoices.getReturnRequestReturnTypeDataTable', $params);
        
        $returnRequestConceptDataTable = new ReturnRequestConceptDataTable($return_request_invoice->id);
        $params = ['return_request_invoice' => $return_request_invoice->id];
        $returnRequestConceptDT = $this->getViewDataTable($returnRequestConceptDataTable, 'return_request_invoices', [], 'return_request_invoices.getReturnRequestConceptDataTable', $params);
        
        return view('return_request_invoices.edit', array_merge(compact("return_request_invoice", "returnRequestReturnTypeDT", "returnRequestConceptDT")), $this->getCommonModels());
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

    public function getReturnRequestInvoiceDataTable(ReturnRequest $return_request)
    {
        return (new ReturnRequestInvoiceDataTable($return_request->id))->render('components.datatable');
    }

    public function getReturnRequestReturnTypeDataTable(ReturnRequestInvoice $return_request_invoice)
    {
        return (new ReturnRequestReturnTypeDataTable($return_request_invoice->id))->render('components.datatable');
    }

    public function getReturnRequestConceptDataTable(ReturnRequestInvoice $return_request_invoice)
    {
        return (new ReturnRequestConceptDataTable($return_request_invoice->id))->render('components.datatable');
    }


    private function getCommonModels()
    {
        $client = Client::where("user_id", auth()->user()->id)->first();
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

        return compact("client", "paymentMethods", "paymentWays", "cfdiUses", "companies", "requestTypes");
    }


  
}
