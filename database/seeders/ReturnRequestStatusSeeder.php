<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReturnRequestStatus;

class ReturnRequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReturnRequestStatus::create([
            "name" => "Incompleta"
        ]);
        ReturnRequestStatus::create([
            "name" => "Por operar"
        ]);
        ReturnRequestStatus::create([
            "name" => "Ingresos"
        ]);
        ReturnRequestStatus::create([
            "name" => "Mesa de control"
        ]);
        ReturnRequestStatus::create([
            "name" => "Egresos"
        ]);
        ReturnRequestStatus::create([
            "name" => "Operada"
        ]);
    }
}
