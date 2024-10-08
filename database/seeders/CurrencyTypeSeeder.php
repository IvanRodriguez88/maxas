<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CurrencyType;

class CurrencyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CurrencyType::create([
            "name" => "MXN",
            "symbol" => "$",
            "description" => "Pesos mexicanos"
        ]);
        CurrencyType::create([
            "name" => "USD",
            "symbol" => "$",
            "description" => "Dólares americanos"
        ]);

        CurrencyType::create([
            "name" => "EURO",
            "symbol" => "€",
            "description" => "Euros"
        ]);
        
    }
}
