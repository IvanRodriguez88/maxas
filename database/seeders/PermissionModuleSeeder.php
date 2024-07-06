<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;

class PermissionModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PermissionModule::create(["name" => "dashboard", "module_type_id" => 2]);
        
        $personal = PermissionModule::create(["name" => "Personal", "description" => "Personal", "module_type_id" => 1]);
        PermissionModule::create(["name" => "roles", "module_type_id" => 2, "parent_id" => $personal->id]);
        PermissionModule::create(["name" => "users", "module_type_id" => 2,"parent_id" => $personal->id]);

        $accounts = PermissionModule::create(["name" => "Accounts", "description" => "Cuentas", "module_type_id" => 1]);
        PermissionModule::create(["name" => "accounts", "module_type_id" => 2, "parent_id" => $accounts->id]);
        PermissionModule::create(["name" => "banks", "module_type_id" => 2, "parent_id" => $accounts->id]);
        PermissionModule::create(["name" => "currency_types", "module_type_id" => 2, "parent_id" => $accounts->id]);

        $companies = PermissionModule::create(["name" => "Companies", "description" => "Cuentas", "module_type_id" => 1]);
        PermissionModule::create(["name" => "companies", "module_type_id" => 2, "parent_id" => $companies->id]);
        PermissionModule::create(["name" => "groups", "module_type_id" => 2, "parent_id" => $companies->id]);
        PermissionModule::create(["name" => "account_statuses", "module_type_id" => 2, "parent_id" => $companies->id]);
        PermissionModule::create(["name" => "intermediaries", "module_type_id" => 2, "parent_id" => $companies->id]);
        PermissionModule::create(["name" => "company_levels", "module_type_id" => 2, "parent_id" => $companies->id]);
        PermissionModule::create(["name" => "bank_separations", "module_type_id" => 2, "parent_id" => $companies->id]);

        $clients = PermissionModule::create(["name" => "Clients", "description" => "Clientes", "module_type_id" => 1]);
        PermissionModule::create(["name" => "client_types", "module_type_id" => 2, "parent_id" => $clients->id]);
        PermissionModule::create(["name" => "clients", "module_type_id" => 2, "parent_id" => $clients->id]);
    
        $returnRequests = PermissionModule::create(["name" => "ReturnRequests", "description" => "Solicitudes de retorno", "module_type_id" => 1]);
        PermissionModule::create(["name" => "return_requests", "module_type_id" => 2, "parent_id" => $returnRequests->id]);
        PermissionModule::create(["name" => "promotor_clients", "module_type_id" => 2, "parent_id" => $returnRequests->id]);
        PermissionModule::create(["name" => "promotors", "module_type_id" => 2, "parent_id" => $returnRequests->id]);
        PermissionModule::create(["name" => "return_bases", "module_type_id" => 2, "parent_id" => $returnRequests->id]);
        PermissionModule::create(["name" => "return_types", "module_type_id" => 2, "parent_id" => $returnRequests->id]);
        
    }
}
