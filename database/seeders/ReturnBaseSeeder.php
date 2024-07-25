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
            "name" => "Total",
            "description" => "Sobre total"
        ]);
        ReturnBase::create([
            "name" => "Subtotal",
            "description" => "Sobre subtotal"
        ]);
        
    }
}
