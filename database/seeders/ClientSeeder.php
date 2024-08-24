<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use App\Models\ClientCompany;
use App\Models\ClientBusiness;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExcelImport;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addClients();
    }
    
    public function addClients(){
        $file = base_path("resources/clientes.xlsx");
        $pages = (Excel::toArray(new ExcelImport(), $file));
        $lastClient = Client::orderBy('id', 'desc')->first();
        if ($lastClient == null) {
            $lastClient = 1;
        }
        foreach ($pages as $key => $page) {
            foreach ($page as $key => $sR) {
                if (trim($sR[0]) == "FIN") {
                    break;
                }
                if ($key > 2) {
                    //Comprbar que el cliente no exista
                    $existClient = Client::where("name", trim($sR[0]))->first();
                    if ($existClient == null) {
                        $user = User::create([
                            "name" => trim($sR[0]),
                            "email" => "cliente".$lastClient."@example.com",
                            'password' => Hash::make("123"),
                            'role_id' => 2,
                        ]);
        
                        $clientType = 1;
                        if (trim($sR[2]) == "Persona Moral") {
                            $clientType = 2;
                        }
        
                        $client = Client::create([
                            'name' => trim($sR[0]), 
                            'user_id' => $user->id, 
                            'client_type_id' => $clientType,
                            'comission_ban' => 0, 
                            'comission_flu'=> 0, 
                            'comission_nom'=> 0, 
                            'promotor_id'=> null,
                            'comission_ban_promotor'=> 0, 
                            'comission_flu_promotor'=> 0, 
                            'comission_nom_promotor'=> 0,
                            'return_base_id' => 1, 
                            'balance' => 0,
                            'is_active' => 1, 
                            'created_by' => 1, 
                            'updated_by' => 1
                        ]);
    
                        ClientBusiness::create([
                            'client_id' => $client->id,
                            'file' => null,
                            'business_name' => trim($sR[0]),
                            'rfc' => trim($sR[1]),
                            'street' => trim($sR[3]),
                            'external_number' => trim($sR[4]),
                            'internal_number' => trim($sR[5]),
                            'cologne' => trim($sR[6]),
                            'city' => trim($sR[7]),
                            'state' => trim($sR[8]),
                            'postal_code' => "x",
                            'is_active' => 1,
                            'created_by' => 1, 
                            'updated_by' => 1
                        ]);
    
                        $lastClient++;
                    }
                }
    
               
            }
        }
    }
}
