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
use App\Http\Controllers\DashboardController;

use App\Models\ReturnRequestStatus;

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
    Route::get('/dashboard', [DashboardController::class, "index"])->name("dashboard.index");

    Route::get('companies/addAccount/{account}', [CompanyController::class, "addAccount"])->name("companies.addAccount");
    Route::get('companies/getDataAutocomplete', [CompanyController::class, "getDataAutocomplete"])->name("companies.getDataAutocomplete");
    Route::get('companies/getAccountsByCompanyId/{company}', [CompanyController::class, "getAccountsByCompanyId"])->name("accounts.getAccountsByCompanyId");
    Route::get('companies/getById/{company}', [CompanyController::class, "getById"])->name("accounts.getById");
    
    Route::get('accounts/getDataAutocomplete', [AccountController::class, "getDataAutocomplete"])->name("accounts.getDataAutocomplete");
	Route::get('accounts/getAccount/{account}', [AccountController::class, "getAccount"])->name("accounts.getAccount");

    Route::get('clients/getDataAutocomplete', [ClientController::class, "getDataAutocomplete"])->name("clients.getDataAutocomplete");
    
    //Rutas para agregar razones sociales (constancias de situacion fiscal) a un cliente
    Route::get('clients/getAddClientBusinessModal', [ClientController::class, "getAddClientBusinessModal"])->name("clients.getAddClientBusinessModal");
    Route::get('clients/getEditClientBusinessModal/{client_business}', [ClientController::class, 'getEditClientBusinessModal'])->name("clients.getEditClientBusinessModal");
    Route::post('clients/addClientBusiness/{client}', [ClientController::class, 'addClientBusiness'])->name("clients.addClientBusiness");
    Route::put('clients/editClientBusiness/{client_business}', [ClientController::class, 'editClientBusiness'])->name("clients.editClientBusiness");
    Route::delete('clients/deleteClientBusiness/{client_business}', [ClientController::class, 'deleteClientBusiness'])->name("clients.deleteClientBusiness");
    Route::get('clients/getClientBusinessDataTable/{client}',  [ClientController::class, 'getClientBusinessDataTable'])->name('clients.getClientBusinessDataTable');
    Route::get('clients/downloadBusinessFile/{client_business}', [ClientController::class, 'downloadBusinessFile'])->name("clients.downloadBusinessFile");
    Route::get('clients/getClientBusinessDataById/{client_business}', [ClientController::class, 'getClientBusinessDataById'])->name("clients.getClientBusinessDataById");

    //-----------------------

    Route::get('return_requests/getReturnRequestReturnTypeDataTable/{return_request}',  [ReturnRequestController::class, 'getReturnRequestReturnTypeDataTable'])->name('return_requests.getReturnRequestReturnTypeDataTable');
    Route::get('return_requests/getReturnRequestConceptDataTable/{return_request}',  [ReturnRequestController::class, 'getReturnRequestConceptDataTable'])->name('return_requests.getReturnRequestConceptDataTable');
    // Route::get('return_requests/sendCabMail/{return_request}', [ReturnRequestController::class, 'sendCabMail'])->name("return_requests.sendCabMail");
    Route::post('return_requests/addClientPaymentProof/{return_request}',  [ReturnRequestController::class, 'addClientPaymentProof'])->name('return_requests.addClientPaymentProof');
    

    //Esto va con permisos
    Route::get('return_requests/getAddReturnTypeModal', [ReturnRequestController::class, 'getAddReturnTypeModal'])->name("return_requests.getAddReturnTypeModal");
    Route::get('return_requests/getEditReturnTypeModal/{return_request_return_type}', [ReturnRequestController::class, 'getEditReturnTypeModal'])->name("return_requests.getEditReturnTypeModal");
    Route::get('return_requests/downloadClientPaymentProof/{return_request}', [ReturnRequestController::class, 'downloadClientPaymentProof'])->name("return_requests.downloadClientPaymentProof");
    Route::get('return_requests/downloadBankPaymentProof/{return_request}', [ReturnRequestController::class, 'downloadBankPaymentProof'])->name("return_requests.downloadBankPaymentProof");
    Route::get('return_requests/downloadDispersionVoucherFile/{return_request_return_type}', [ReturnRequestController::class, 'downloadDispersionVoucherFile'])->name("return_requests.downloadDispersionVoucherFile");
    Route::get('return_requests/downloadInvoice/{return_request}', [ReturnRequestController::class, 'downloadInvoice'])->name("return_requests.downloadInvoice");


    Route::post('return_requests/addReturnRequestType/{return_request}', [ReturnRequestController::class, 'addReturnRequestType'])->name("return_requests.addReturnRequestType");
    Route::put('return_requests/editReturnRequestType/{return_request_return_type}', [ReturnRequestController::class, 'editReturnRequestType'])->name("return_requests.editReturnRequestType");
    Route::delete('return_requests/deleteReturnRequestType/{return_request_return_type}', [ReturnRequestController::class, 'deleteReturnRequestType'])->name("return_requests.deleteReturnRequestType");


    Route::get('return_requests/getAddReturnConceptModal', [ReturnRequestController::class, 'getAddReturnConceptModal'])->name("return_requests.getAddReturnConceptModal");
    Route::get('return_requests/getEditReturnConceptModal/{return_request_concept}', [ReturnRequestController::class, 'getEditReturnConceptModal'])->name("return_requests.getEditReturnConceptModal");
    
    Route::post('return_requests/addReturnRequestConcept/{return_request}', [ReturnRequestController::class, 'addReturnRequestConcept'])->name("return_requests.addReturnRequestConcept");
    Route::put('return_requests/editReturnRequestConcept/{return_request_concept}', [ReturnRequestController::class, 'editReturnRequestConcept'])->name("return_requests.editReturnRequestConcept");
    Route::delete('return_requests/deleteReturnRequestConcept/{return_request_concept}', [ReturnRequestController::class, 'deleteReturnRequestConcept'])->name("return_requests.deleteReturnRequestConcept");

    Route::get('return_requests/getAddDispersionVoucherFileModal/{return_request_return_type}', [ReturnRequestController::class, 'getAddDispersionVoucherFileModal'])->name("return_requests.getAddDispersionVoucherFileModal");
    Route::post('return_requests/addDispersionVoucherFile/{return_request_return_type}', [ReturnRequestController::class, 'addDispersionVoucherFile'])->name("return_requests.addDispersionVoucherFile");


    Route::put('return_requests/changeStatus/{return_request}/{status_id}', [ReturnRequestController::class, 'changeStatus'])->name("return_requests.changeStatus");
    Route::put('return_requests/updateIngresos/{return_request}', [ReturnRequestController::class, 'updateIngresos'])->name("return_requests.updateIngresos");
    Route::put('return_requests/updateMesaControl/{return_request}', [ReturnRequestController::class, 'updateMesaControl'])->name("return_requests.updateMesaControl");
    Route::put('return_requests/updateEgresos/{return_request}', [ReturnRequestController::class, 'updateEgresos'])->name("return_requests.updateEgresos");
    Route::put('return_requests/addInvoice/{return_request}', [ReturnRequestController::class, 'addInvoice'])->name("return_requests.addInvoice");

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
        Route::resource('intermediaries', IntermediaryController::class);
        Route::resource('company_levels', CompanyLevelController::class);
        Route::resource('bank_separations', BankSeparationController::class);

        //Clientes
        Route::resource('clients', ClientController::class);
        Route::resource('client_types', ClientTypeController::class);


        //Solicitudes de retorno
        Route::resource('return_types', ReturnTypeController::class);
        Route::resource('return_bases', ReturnBaseController::class);

        Route::resource('promotors', PromotorController::class);
        Route::resource('return_requests', ReturnRequestController::class);

    });
    Route::put("roles/savePermissions/{role}", [RoleController::class, "savePermissions"])->name("roles.savePermissions");
});


Route::get('/unauthorized', function () {
    return view('pages.page.unauthorized', ['title' => 'Usuario no autorizado']);
})->name("unauthorized");
