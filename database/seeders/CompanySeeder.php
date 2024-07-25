<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            "name" => "Sakara",
            'group_id' => 1, 
            'intermediary_id' => 1, 
            'company_level_id' => 1, 
            'social_object' => "Este es un objeto social de prueba", 
        ]);
    }
}
