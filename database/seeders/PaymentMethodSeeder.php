<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::create([
            "name" => "PUE",
            "description" => "Pago en una sola exhibición"
        ]);

        PaymentMethod::create([
            "name" => "PPD",
            "description" => "Pago en parcialidades o diferido"
        ]);
    }
}
