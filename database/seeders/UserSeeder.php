<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash; // Importar la fachada Hash

class UserSeeder extends Seeder
{
   
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersArray = array(
            array('id' => '1','name' => 'Admin','email' => 'admin@playsoluciones.com','role_id' => '1','email_verified_at' => NULL,'password' => '$2y$10$/GRLpL.Jr/dCI/fprhu2buZYyfMJAoyGkJchhaucpUMzOdJtfXyfi','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 09:20:35','updated_at' => '2024-08-02 09:20:35','is_active' => '1'),
            array('id' => '2','name' => 'Guillermo Villanueva','email' => 'contraloria@playsoluciones.com','role_id' => '5','email_verified_at' => NULL,'password' => '$2y$10$DzIESKtZx5OPWfxEmdPxqek/kmIarrCDkxi2YRr9S8SmQnSVRjSne','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 10:49:44','updated_at' => '2024-08-02 10:49:44','is_active' => '1'),
            array('id' => '3','name' => 'Jovanna','email' => 'facturacion@playsoluciones.com','role_id' => '7','email_verified_at' => NULL,'password' => '$2y$10$Qi/vANE2rYUsQdrhv75clOH4CEWEX4ys3etePeqzogG8AS9iHEfHW','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 10:51:03','updated_at' => '2024-08-02 10:51:03','is_active' => '1'),
            array('id' => '4','name' => 'Juan Manuel','email' => 'tesoreria@playsoluciones.com','role_id' => '6','email_verified_at' => NULL,'password' => '$2y$10$GYGUxRU7yXwbHicmQbwfB.ySs6tsoU9H83f7hVdTzQL5pND8XiSSu','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 10:52:44','updated_at' => '2024-08-02 10:52:44','is_active' => '1'),
            array('id' => '5','name' => 'Gerardo Bermudaz','email' => 'contabilidad@playsoluciones.com','role_id' => '8','email_verified_at' => NULL,'password' => '$2y$10$RWSUJxzi5n3LeXJ2Z6w.JOrchSnl4bhCxSLXLjPt7LMckNcqtMnfq','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 10:53:22','updated_at' => '2024-08-02 10:53:22','is_active' => '1'),
            array('id' => '6','name' => 'Xochitl Torres','email' => 'tesoreria1@playsoluciones.com','role_id' => '5','email_verified_at' => NULL,'password' => '$2y$10$5RXL387ZSHt7HleB6s1mXuxki4ijjXUbFKHmdT.wvXSFuS97BTJRy','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 11:07:44','updated_at' => '2024-08-02 11:07:44','is_active' => '1'),
            array('id' => '7','name' => 'Leslie García','email' => 'gastos@playsoluciones.com','role_id' => '7','email_verified_at' => NULL,'password' => '$2y$10$sDDfF/REdcgetICwsC8MEO2APqe3RQjYbwumyH2LAi/9GOHMl82DO','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 11:14:19','updated_at' => '2024-08-02 11:14:19','is_active' => '1'),
            array('id' => '8','name' => 'Caballero','email' => 'caballero@playsoluciones.com','role_id' => '4','email_verified_at' => NULL,'password' => '$2y$10$LGiHdjQOqoPrhtBtH0L/UO5dFIVc.adt2878i82bExYzQxR0GoLK.','two_factor_secret' => NULL,'two_factor_recovery_codes' => NULL,'two_factor_confirmed_at' => NULL,'remember_token' => NULL,'created_at' => '2024-08-02 11:51:00','updated_at' => '2024-08-02 11:51:00','is_active' => '1'),
          );

        foreach ($usersArray as $user) {
            User::create($user);
        }
    }
}
