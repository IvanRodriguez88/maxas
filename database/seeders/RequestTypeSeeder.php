<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RequestType;

class RequestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestType::create([
            "name" => "Bancarización"
        ]);
        RequestType::create([
            "name" => "Flujo"
        ]);
        RequestType::create([
            "name" => "Nóminas"
        ]);
    }
}
