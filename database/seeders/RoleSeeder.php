<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            "name" => "Admin",
        ]);
        Role::create([
            "name" => "Cliente",
        ]);
        Role::create([
            "name" => "Promotor",
        ]);
        Role::create([
            "name" => "Intermediario",
        ]);

        Role::create([
            "name" => "Operaciones",
        ]);
        Role::create([
            "name" => "Ingresos",
        ]);
        Role::create([
            "name" => "Mesa de control",
        ]);
        Role::create([
            "name" => "Egresos",
        ]);
    }
}
