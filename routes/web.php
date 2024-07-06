<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\CurrencyTypeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AccountStatusController;
use App\Http\Controllers\IntermediaryController;
use App\Http\Controllers\CompanyLevelController;
use App\Http\Controllers\BankSeparationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ClientTypeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ReturnTypeController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\ReturnBaseController;
use App\Http\Controllers\PromotorController;
use App\Http\Controllers\PromotorClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Ruta para el cliente, sin permisos, para dar de alta una nueva solicitud
Route::get('return_requests/new', [ReturnRequestController::class, "new"])->name("return_requests.new");


Route::middleware("auth")->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard', ['title' => 'Inicio']);
    })->name("dashboard.index");

    Route::get('companies/addAccount/{account}', [CompanyController::class, "addAccount"])->name("companies.addAccount");
    Route::get('companies/getDataAutocomplete', [CompanyController::class, "getDataAutocomplete"])->name("companies.getDataAutocomplete");
    Route::get('companies/getAccountsByCompanyId/{company}', [CompanyController::class, "getAccountsByCompanyId"])->name("accounts.getAccountsByCompanyId");
    Route::get('companies/getById/{company}', [CompanyController::class, "getById"])->name("accounts.getById");
    
    Route::get('accounts/getDataAutocomplete', [AccountController::class, "getDataAutocomplete"])->name("accounts.getDataAutocomplete");

    Route::get('clients/getDataAutocomplete', [ClientController::class, "getDataAutocomplete"])->name("clients.getDataAutocomplete");
    
    Route::get('return_requests/getReturnRequestReturnTypeDataTable/{return_request}',  [ReturnRequestController::class, 'getReturnRequestReturnTypeDataTable'])->name('return_requests.getReturnRequestReturnTypeDataTable');
    // Route::get('return_requests/sendCabMail/{return_request}', [ReturnRequestController::class, 'sendCabMail'])->name("return_requests.sendCabMail");


    Route::get('promotors/getAddPromotorClientModal', [PromotorController::class, 'getAddPromotorClientModal'])->name("promotors.getAddPromotorClientModal");


    //Esto va con permisos
    Route::get('return_requests/getAddReturnTypeModal', [ReturnRequestController::class, 'getAddReturnTypeModal'])->name("return_requests.getAddReturnTypeModal");
    Route::get('return_requests/getEditReturnTypeModal/{return_request_return_type}', [ReturnRequestController::class, 'getEditReturnTypeModal'])->name("return_requests.getEditReturnTypeModal");
    Route::get('return_requests/downloadClientPaymentProof/{return_request}', [ReturnRequestController::class, 'downloadClientPaymentProof'])->name("return_requests.downloadClientPaymentProof");


    Route::post('return_requests/addReturnRequestType/{return_request}', [ReturnRequestController::class, 'addReturnRequestType'])->name("return_requests.addReturnRequestType");
    Route::put('return_requests/editReturnRequestType/{return_request_return_type}', [ReturnRequestController::class, 'editReturnRequestType'])->name("return_requests.editReturnRequestType");
    Route::delete('return_requests/deleteReturnRequestType/{return_request_return_type}', [ReturnRequestController::class, 'deleteReturnRequestType'])->name("return_requests.deleteReturnRequestType");


    Route::middleware(['permission'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);

        //Cuentas
       
        Route::resource('accounts', AccountController::class);
        Route::resource('banks', BankController::class);
        Route::resource('currency_types', CurrencyTypeController::class);

        //Empresas
        Route::resource('companies', CompanyController::class);
        Route::resource('groups', GroupController::class);
        Route::resource('account_statuses', AccountStatusController::class);
        Route::resource('intermediaries', IntermediaryController::class);
        Route::resource('company_levels', CompanyLevelController::class);
        Route::resource('bank_separations', BankSeparationController::class);

        //Clientes
        Route::resource('clients', ClientController::class);
        Route::resource('client_types', ClientTypeController::class);


        //Solicitudes de retorno
        Route::resource('return_types', ReturnTypeController::class);
        Route::resource('return_bases', ReturnBaseController::class);

        
        Route::post('promotor_clients', [PromotorClientController::class, 'store'])->name("promotor_clients.store");
        Route::delete('promotor_clients/{promotor_client}', [PromotorClientController::class, 'destroy'])->name("promotor_clients.destroy");

        Route::resource('promotors', PromotorController::class);
        Route::resource('return_requests', ReturnRequestController::class);

    });
    Route::put("roles/savePermissions/{role}", [RoleController::class, "savePermissions"])->name("roles.savePermissions");
});


Route::get('/unauthorized', function () {
    return view('pages.page.unauthorized', ['title' => 'Usuario no autorizado']);
})->name("unauthorized");
