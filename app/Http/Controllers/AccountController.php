<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\AccountDataTable;
use App\Http\Requests\AccountRequest;
use App\Models\Account;
use App\Models\Bank;
use App\Models\CurrencyType;
use App\Models\BankSeparation;

use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index(AccountDataTable $dataTable)
    {
        $allowAdd = auth()->user()->hasPermissions("accounts.create");
        return $dataTable->render('accounts.index', compact("allowAdd"));
    }

    private function getCommonModels()
    {
        $bankSeparations = BankSeparation::where("is_active", 1)->pluck("name", "id");
        $banks = Bank::where("is_active", 1)->pluck("name", "id");
        $currency_types = CurrencyType::where("is_active", 1)->pluck("name", "id");
        return compact("banks", "bankSeparations", "currency_types",);
    }

    public function create()
    {
        return view('accounts.create', $this->getCommonModels());
    }

    public function store(AccountRequest $request)
    {
        $status = true;
		$account = null;

        $params = array_merge($request->all(), [
            "bank_id" => $request->bank_id,
            "currency_type_id" => $request->currency_type_id,
            "account_number" => $request->account_number,
            "clabe" => $request->clabe,
            "ava" => $request->ava,
            "swift" => $request->swift,
            'is_active' => !is_null($request->is_active),
            'created_by' => auth()->user()->id,
            'updated_by' => auth()->user()->id,
		]);
        
		try {
            $account = Account::create($params);
            $message = "Cuenta creada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'accounts');
		}
        return $this->getResponse($status, $message, $account);
    }

    public function edit(Account $account)
    {
        return view('accounts.edit', array_merge($this->getCommonModels(), compact("account")));
    }

    public function update(AccountRequest $request, Account $account)
    {
        $status = true;
        $params = array_merge($request->all(), [
            "bank_id" => $request->bank_id,
            "currency_type_id" => $request->currency_type_id,
            "account_number" => $request->account_number,
            "clabe" => $request->clabe,
            "ava" => $request->ava,
            "swift" => $request->swift,
            'is_active' => !is_null($request->is_active),
            'updated_by' => auth()->user()->id,
		]);
		try {
            $account->update($params);
            $message = "Cuenta modificada correctamente";
		} catch (\Illuminate\Database\QueryException $e) {
            $status = false;
			$message = $this->getErrorMessage($e, 'accounts');
		}
        return $this->getResponse($status, $message, $account);
    }

    public function destroy(Account $account)
    {
        $status = true;
        try {
            $account->update([
                "is_active" => false,
                "updated_by" => auth()->user()->id
            ]);
            $message = "Banco desactivado correctamente";
        } catch (\Illuminate\Database\QueryException $e) {
            $status = false;
            $message = $this->getErrorMessage($e, 'accounts');
        }
        return $this->getResponse($status, $message);
    }

    public function getDataAutocomplete()
    {
        $accounts = Account::select(
            "accounts.id",
            DB::raw("
                CASE
                    WHEN account_number IS NOT NULL AND clabe IS NOT NULL THEN CONCAT(banks.name, ' - ', account_number)
                    WHEN account_number IS NOT NULL THEN CONCAT(banks.name, ' - ', account_number)
                    WHEN clabe IS NOT NULL THEN CONCAT(banks.name, ' - ', clabe)
                    ELSE banks.name
                END as name
            ")
        )
        ->leftJoin('banks', 'accounts.bank_id', '=', 'banks.id')
        ->get();

        $formattedAccounts = $accounts->map(function ($account) {
            return [
                'id' => $account->id,
                'name' => $account->name
            ];
        });

        return response()->json($formattedAccounts);    
    }

	public function getAccount(Account $account)
	{
		return view("accounts.info", compact("account"))->render();    
	}

}
