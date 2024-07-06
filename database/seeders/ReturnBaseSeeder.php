<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ReturnBase;

class ReturnBaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReturnBase::create([
            "name" => "T",
            "description" => "Sobre total"
        ]);
        ReturnBase::create([
            "name" => "ST",
            "description" => "Sobre subtotal"
        ]);
        ReturnBase::create([
            "name" => "IVA",
            "description" => "Sobre IVA"
        ]);
        ReturnBase::create([
            "name" => "STR",
            "description" => "Sobre total a retornar"
        ]);
    }
}
