<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankSeparation;

class BankSeparationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BankSeparation::create([
            "name" => "Vault"
        ]);
        BankSeparation::create([
            "name" => "Comercial"
        ]);
    }
}
