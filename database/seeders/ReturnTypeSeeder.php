<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReturnType;

class ReturnTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReturnType::create([
            "name" => "Efectivo"
        ]);
        ReturnType::create([
            "name" => "Trasnferencia"
        ]);
        ReturnType::create([
            "name" => "Nómina"
        ]);
        ReturnType::create([
            "name" => "Pago de tarjetas"
        ]);
    }
}
