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
        $companies = array(
            array('id' => '1','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '2','name' => 'ASESORES FINANCIEROS VILMAR','social_object' => 'x','created_at' => '2024-08-02 12:18:20','updated_at' => '2024-08-02 12:22:49','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '2','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'BAO SERVICIOS DE ADMINISTRACION','social_object' => 'x','created_at' => '2024-08-02 12:19:34','updated_at' => '2024-08-02 12:19:34','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '3','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '3','name' => 'COMERCIALIZADORA FERRIE','social_object' => 'x','created_at' => '2024-08-02 12:25:11','updated_at' => '2024-08-02 12:25:11','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '4','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'GRUPO MIXBIS SA DE CV','social_object' => 'x','created_at' => '2024-08-02 12:26:18','updated_at' => '2024-08-02 12:26:18','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '5','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'HA ESTRUCTURA KPTL SAPI','social_object' => 'x','created_at' => '2024-08-02 12:28:44','updated_at' => '2024-08-02 12:28:44','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '6','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '1','name' => 'OKANE ASESORES EMPRESARIALES','social_object' => 'x','created_at' => '2024-08-02 12:29:27','updated_at' => '2024-08-02 12:29:27','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '7','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '2','name' => 'PEYARELI SERVICIOS INTEGRALES','social_object' => 'x','created_at' => '2024-08-02 12:30:08','updated_at' => '2024-08-02 12:30:08','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '8','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '3','name' => 'PUBLICIDAD PRIMERA MANO','social_object' => 'x','created_at' => '2024-08-02 12:30:41','updated_at' => '2024-08-02 12:30:41','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '9','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '1','name' => 'ROBLEDO Y PALACIOS','social_object' => 'x','created_at' => '2024-08-02 12:31:23','updated_at' => '2024-08-02 12:31:23','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '10','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'SAAVAN LUO SA DE CV','social_object' => 'x','created_at' => '2024-08-02 12:32:58','updated_at' => '2024-08-02 12:32:58','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '11','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '1','name' => 'SAKARA CONSTRUCCIONES','social_object' => 'x','created_at' => '2024-08-02 12:33:46','updated_at' => '2024-08-02 12:33:46','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '12','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'SERVICIO ADMINISTRATIVO MUNA','social_object' => 'x','created_at' => '2024-08-02 12:35:27','updated_at' => '2024-08-02 12:35:27','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '13','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '3','name' => 'SINDICATO AUTONOMO DE TRABAJADORES','social_object' => 'x','created_at' => '2024-08-02 12:36:06','updated_at' => '2024-08-02 12:36:06','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '14','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '3','name' => 'SINDICATO INDUSTRIAL Y DE SERVICIOS','social_object' => 'x','created_at' => '2024-08-02 12:37:02','updated_at' => '2024-08-02 12:38:27','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '15','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'SOFTMALI SA DE CV','social_object' => 'x','created_at' => '2024-08-02 12:39:23','updated_at' => '2024-08-02 12:39:23','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '16','group_id' => '3','intermediary_id' => NULL,'company_level_id' => '1','name' => 'TARAU','social_object' => 'x','created_at' => '2024-08-02 12:39:52','updated_at' => '2024-08-02 12:39:52','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '17','group_id' => '1','intermediary_id' => NULL,'company_level_id' => '3','name' => 'TRANSPORTES PUNTO DE VENTA','social_object' => 'x','created_at' => '2024-08-02 12:40:31','updated_at' => '2024-08-02 12:40:50','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '18','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'TURISMO MADHYA SA DE CV','social_object' => 'x','created_at' => '2024-08-02 12:41:37','updated_at' => '2024-08-02 12:41:37','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '19','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'VECAM SERVICIOS MEDICOS','social_object' => 'x','created_at' => '2024-08-02 12:42:37','updated_at' => '2024-08-02 12:42:37','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1'),
            array('id' => '20','group_id' => '2','intermediary_id' => NULL,'company_level_id' => '1','name' => 'YAZAW PUBLICIDAD SA DE CV','social_object' => 'x','created_at' => '2024-08-02 12:43:35','updated_at' => '2024-08-02 12:43:35','notes' => NULL,'is_active' => '1','created_by' => '1','updated_by' => '1')
          );

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
