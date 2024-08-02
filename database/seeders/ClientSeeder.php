<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;
use App\Models\User;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       

        Client::create([
            "name" => "Cliente 1",
            "user_id" => 2,
            "client_type_id" => 1,
            'comission_ban' => 3,
            'comission_flu' => 3, 
            'comission_nom' => 3, 
            'return_base_id' => 1,
        ]);
    }
}
