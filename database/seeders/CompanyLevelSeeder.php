<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyLevel;

class CompanyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CompanyLevel::create([
            "name" => "Nivel 1"
        ]);
        CompanyLevel::create([
            "name" => "Nivel 2"
        ]);
        CompanyLevel::create([
            "name" => "Nivel 3"
        ]);
    }
}
