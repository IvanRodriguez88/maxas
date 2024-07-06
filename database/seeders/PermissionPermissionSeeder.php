<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PermissionModule;
use App\Models\PermissionFunction   ;
use App\Models\PermissionPermission;

class PermissionPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions(["dashboard"], ["index"], false);
        $this->createPermissions([
			"users", 
			"roles", 
			"banks", 
			"companies",
			"currency_types", 
			"groups",
			"account_statuses",
			"intermediaries",
			"company_levels",
			"bank_separations",
			"client_types",
			"return_requests",
			"return_bases",
			"return_types",
			"promotors",
		]);
		$this->createPermissions(["clients"]);
		$this->createPermissions(["accounts"]);
		$this->createPermissions(["promotor_clients"], ["store", "destroy"], false);
    }

    public function createPermissions($moduleNames = [], $functionNames = [], $addCrudFunctions = true) {
		$defaultFunctions = ["index","store","create","show","update","destroy","edit"];
		$modules = PermissionModule::where("module_type_id", 2)->whereIn("name", $moduleNames)->get();
		if($addCrudFunctions) {
			$functionNames = array_merge($defaultFunctions, $functionNames);
		}
		$functions = PermissionFunction::whereIn("name", $functionNames)->get();
		
		foreach ($modules as $key => $module) {
			foreach ($functions as $key => $function) {
				PermissionPermission::create(["module_id" => $module->id, "function_id" => $function->id]);
			}
		}
	}
}
