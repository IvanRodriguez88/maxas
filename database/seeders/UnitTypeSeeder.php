<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UnitType; 

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unitTypes = [
            ["code" => "H87", "name" => "Pieza"],
            ["code" => "EA", "name" => "Elemento"],
            ["code" => "E48", "name" => "Unidad de Servicio"],
            ["code" => "ACT", "name" => "Actividad"],
            ["code" => "KGM", "name" => "Kilogramo"],
            ["code" => "E51", "name" => "Trabajo"],
            ["code" => "A9", "name" => "Tarifa"],
            ["code" => "MTR", "name" => "Metro"],
            ["code" => "AB", "name" => "Paquete a granel"],
            ["code" => "BB", "name" => "Caja base"],
            ["code" => "KT", "name" => "Kit"],
            ["code" => "SET", "name" => "Conjunto"],
            ["code" => "LTR", "name" => "Litro"],
            ["code" => "XBX", "name" => "Caja"],
            ["code" => "MON", "name" => "Mes"],
            ["code" => "HUR", "name" => "Hora"],
            ["code" => "MTK", "name" => "Metro cuadrado"],
            ["code" => "11", "name" => "Equipos"],
            ["code" => "MGM", "name" => "Miligramo"],
            ["code" => "XPK", "name" => "Paquete"],
            ["code" => "XKI", "name" => "Kit (Conjunto de piezas)"],
            ["code" => "AS", "name" => "Variedad"],
            ["code" => "GRM", "name" => "Gramo"],
            ["code" => "PR", "name" => "Par"],
            ["code" => "DPC", "name" => "Docenas de piezas"],
            ["code" => "xun", "name" => "Unidad"],
            ["code" => "DAY", "name" => "Día"],
            ["code" => "XLT", "name" => "Lote"],
            ["code" => "10", "name" => "Grupos"],
            ["code" => "MLT", "name" => "Mililitro"],
            ["code" => "E54", "name" => "Viaje"],
        ];

        foreach ($unitTypes as $unitType) {
            UnitType::create($unitType);
        }
    }
}
