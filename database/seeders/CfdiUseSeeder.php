<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CfdiUse;

class CfdiUseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cfdiUses = [
            ["code" => "G01", "name" => "Adquisición de mercancías.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "G02", "name" => "Devoluciones, descuentos o bonificaciones.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "G03", "name" => "Gastos en general.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I01", "name" => "Construcciones.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I02", "name" => "Mobiliario y equipo de oficina por inversiones.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I03", "name" => "Equipo de transporte.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I04", "name" => "Equipo de computo y accesorios.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I05", "name" => "Dados, troqueles, moldes, matrices y herramental.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I06", "name" => "Comunicaciones telefónicas.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I07", "name" => "Comunicaciones satelitales.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "I08", "name" => "Otra maquinaria y equipo.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "D01", "name" => "Honorarios médicos, dentales y gastos hospitalarios.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D02", "name" => "Gastos médicos por incapacidad o discapacidad.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D03", "name" => "Gastos funerales.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D04", "name" => "Donativos.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D05", "name" => "Intereses reales efectivamente pagados por créditos hipotecarios (casa habitación).", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D06", "name" => "Aportaciones voluntarias al SAR.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D07", "name" => "Primas por seguros de gastos médicos.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D08", "name" => "Gastos de transportación escolar obligatoria.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D09", "name" => "Depósitos en cuentas para el ahorro, primas que tengan como base planes de pensiones.", "physical_person" => 1, "moral_person" => 0],
            ["code" => "D10", "name" => "Pagos por servicios educativos (colegiaturas).", "physical_person" => 1, "moral_person" => 0],
            ["code" => "S01", "name" => "Sin efectos fiscales.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "CP01", "name" => "Pagos.", "physical_person" => 1, "moral_person" => 1],
            ["code" => "CN01", "name" => "Nómina.", "physical_person" => 1, "moral_person" => 0],
        ];

        foreach ($cfdiUses as $cfdiUse) {
            CfdiUse::create($cfdiUse);
        }

        
    }
}
