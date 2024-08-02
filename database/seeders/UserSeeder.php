<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Importar la fachada Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Admin",
            "email" => "admin@play.com",
            "password" => Hash::make("secret"),
            "role_id" => 1
        ]);

        User::create([
            "name" => "Ivan",
            "email" => "cliente@play.com",
            "password" => Hash::make("123"),
            "role_id" => 2
        ]);

        User::create([
            "name" => "Caballero",
            "email" => "cab@play.com",
            "password" => Hash::make("123"),
            "role_id" => 4
        ]);
    }
}
