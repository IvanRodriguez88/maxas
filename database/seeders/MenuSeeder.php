<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\PermissionPermission;
use App\Models\PermissionModule;
use App\Models\PermissionFunction;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Menu::create([
            "name" => "Inicio",
            "parent_id" => null,
            "position" => 0.9,
            "permission_id" => $this->getPermissionId("dashboard")
        ]);
        
        //Si es un menu que tiene hijos este no tendrá permisos, ya que solo será para desplegar los hijos
        $users = Menu::create([
            "name" => "Usuarios",
            "parent_id" => null,
            "position" => 1,
        ]);

        Menu::create([
            "name" => "Roles",
            "parent_id" => $users->id,
            "position" => 2,
            "permission_id" => $this->getPermissionId("roles")
        ]);

        Menu::create([
            "name" => "Usuarios",
            "parent_id" => $users->id,
            "position" => 3,
            "permission_id" => $this->getPermissionId("users")
        ]);

        $accounts = Menu::create([
            "name" => "Cuentas",
            "parent_id" => null,
            "position" => 4,
        ]);

        Menu::create([
            "name" => "Cuentas",
            "parent_id" => $accounts->id,
            "position" => 5,
            "permission_id" => $this->getPermissionId("accounts")
        ]);


        Menu::create([
            "name" => "Bancos",
            "parent_id" => $accounts->id,
            "position" => 6,
            "permission_id" => $this->getPermissionId("banks")
        ]);

        Menu::create([
            "name" => "Tipos de moneda",
            "parent_id" => $accounts->id,
            "position" => 7,
            "permission_id" => $this->getPermissionId("currency_types")
        ]);

        $companies = Menu::create([
            "name" => "Empresas",
            "parent_id" => null,
            "position" => 8,
        ]);
        Menu::create([
            "name" => "Empresas",
            "parent_id" => $companies->id,
            "position" => 8.5,
            "permission_id" => $this->getPermissionId("companies")
        ]);
        Menu::create([
            "name" => "Grupos",
            "parent_id" => $companies->id,
            "position" => 9,
            "permission_id" => $this->getPermissionId("groups")
        ]);
        Menu::create([
            "name" => "Tipos de estados",
            "parent_id" => $companies->id,
            "position" => 10,
            "permission_id" => $this->getPermissionId("account_statuses")
        ]);
        Menu::create([
            "name" => "Intermediarios",
            "parent_id" => $companies->id,
            "position" => 11,
            "permission_id" => $this->getPermissionId("intermediaries")
        ]);
        Menu::create([
            "name" => "Niveles de empresa",
            "parent_id" => $companies->id,
            "position" => 12,
            "permission_id" => $this->getPermissionId("company_levels")
        ]);
        Menu::create([
            "name" => "Separación de bancos",
            "parent_id" => $companies->id,
            "position" => 13,
            "permission_id" => $this->getPermissionId("bank_separations")
        ]);

        
        $clients = Menu::create([
            "name" => "Clientes",
            "parent_id" => null,
            "position" => 14,
        ]);

        Menu::create([
            "name" => "Clientes",
            "parent_id" => $clients->id,
            "position" => 15,
            "permission_id" => $this->getPermissionId("clients")
        ]);

        Menu::create([
            "name" => "Tipos de cliente",
            "parent_id" => $clients->id,
            "position" => 16,
            "permission_id" => $this->getPermissionId("client_types")
        ]);

        $returnRequests = Menu::create([
            "name" => "Solicitudes",
            "parent_id" => null,
            "position" => 17,
        ]);

        Menu::create([
            "name" => "Solicitudes de retorno",
            "parent_id" => $returnRequests->id,
            "position" => 18,
            "permission_id" => $this->getPermissionId("return_requests")
        ]);

        Menu::create([
            "name" => "Promotores",
            "parent_id" => $returnRequests->id,
            "position" => 18.1,
            "permission_id" => $this->getPermissionId("promotors")
        ]);

        Menu::create([
            "name" => "Bases de retorno",
            "parent_id" => $returnRequests->id,
            "position" => 19,
            "permission_id" => $this->getPermissionId("return_bases")
        ]);

        Menu::create([
            "name" => "Tipos de retorno",
            "parent_id" => $returnRequests->id,
            "position" => 20,
            "permission_id" => $this->getPermissionId("return_types")
        ]);

    }

    private function getPermissionId($module_name){
        $module = PermissionModule::where("module_type_id", 2)->where("name", $module_name)->first();
        $function = PermissionFunction::where("name", "index")->first();

        $permission = PermissionPermission::where("module_id", $module->id)->where("function_id", $function->id)->first();

        return $permission->id;
    }
}
