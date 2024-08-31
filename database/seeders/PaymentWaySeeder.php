<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentWay;

class PaymentWaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        PaymentWay::create([
            "code" => "02",
            "name" => "Cheque nominativo",
        ]);
        
        PaymentWay::create([
            "code" => "03",
            "name" => "Transferencia electrónica de fondos",
        ]);
        
        PaymentWay::create([
            "code" => "04",
            "name" => "Tarjeta de crédito",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "05",
            "name" => "Monedero electrónico",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "06",
            "name" => "Dinero electrónico",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "08",
            "name" => "Vales de despensa",
            "is_active" => 0
        ]); 
        
        
        PaymentWay::create([
            "code" => "12",
            "name" => "Dación en pago",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "13",
            "name" => "Pago por subrogación",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "14",
            "name" => "Pago por consignación",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "15",
            "name" => "Condonación",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "17",
            "name" => "Compensación",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "23",
            "name" => "Novación",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "24",
            "name" => "Confusión",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "25",
            "name" => "Remisión de deuda",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "26",
            "name" => "Prescripción o caducidad",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "27",
            "name" => "A satisfacción del acreedor",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "28",
            "name" => "Tarjeta de débito",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "29",
            "name" => "Tarjeta de servicios",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "30",
            "name" => "Aplicación de anticipos",
            "is_active" => 0
        ]);
        
        PaymentWay::create([
            "code" => "99",
            "name" => "Por definir",
        ]);
        

        
    }
}
