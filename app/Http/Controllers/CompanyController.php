<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\CompanyDataTable;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Group;
use App\Models\Intermediary;
use App\Models\CompanyLevel;
use App\Models\Account;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index(CompanyDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("companies.create");
        return $dataTable->render('companies.index', compact("allowAdd"));
    }

    private function getCommonModels()
    {
        $groups = Group::where("is_active", 1)->pluck("name", "id");
        $intermediaries = Intermediary::where("is_active", 1)->pluck("name", "id");
        $companyLevels = CompanyLevel::where("is_active", 1)->pluck("name", "id");

        return compact("groups", "intermediaries", "companyLevels");
    }

    public function create()
    {
        return view('companies.create', $this->getCommonModels());
    }

    public function store(CompanyRequest $request)
    {
        $status = true;
		$company = null;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $company = Company::create($params);
            $company->accounts()->attach($params["account_id"]);
            $message = "Empresa creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'companies');
		}
        return $this->getResponse($status, $message, $company);
    }

    
    public function edit(Company $company)
    {
        return view('companies.edit', array_merge($this->getCommonModels(), compact('company')));
    }

    
    public function update(CompanyRequest $request, Company $company)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "name" => $request->name,
            "description" => $request->description,
            "updated_by" => auth()->user()->id,
            'is_active' => !is_null($request->is_active),
		]);

        try {
            $company->update($params);
            $company->accounts()->sync($params["account_id"]);
            $message = "Empresa modificada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'companies');
        }
        return $this->getResponse($status, $message, $company);
    
    }

    public function destroy(Company $company)
    {
        $status = true;
        try {
            $company->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Empresa desactivada correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'companies');
        }
        return $this->getResponse($status, $message);
    }

    public function addAccount(Account $account)
    {
        return view('companies.account_card', compact('account'))->render();
    }

    public function getDataAutocomplete()
    {
        $companies = Company::select(
            "id",
            DB::raw("companies.name as name")
        )->get();

        $formattedCompanies = $companies->map(function ($company) {
            return [
                'id' => $company->id,
                'name' => $company->name
            ];
        });

        return response()->json($formattedCompanies);    
    }

    //Obitiene las cuentas que tiene asociadas una empresa
    public function getAccountsByCompanyId(Company $company)
    {
        return response()->json($company->accounts->load(["bank"]));    
    }

    public function getById(Company $company)
    {
        return response()->json($company);    
    }

}
