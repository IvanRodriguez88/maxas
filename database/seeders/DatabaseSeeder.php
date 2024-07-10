<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\PermissionModuleSeeder;
use Database\Seeders\PermissionFunctionSeeder;
use Database\Seeders\PermissionPermissionSeeder;
use Database\Seeders\PermissionPermissionRoleSeeder;
use Database\Seeders\MenuSeeder;
use Database\Seeders\ModuleTypeSeeder;
use Database\Seeders\BankSeeder;
use Database\Seeders\CurrencyTypeSeeder;
use Database\Seeders\AccountSeeder;
use Database\Seeders\GroupSeeder;
use Database\Seeders\AccountStatusSeeder;
use Database\Seeders\IntermediarySeeder;
use Database\Seeders\CompanyLevelSeeder;
use Database\Seeders\BankSeparationSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\ClientTypeSeeder;
use Database\Seeders\ClientSeeder;
use Database\Seeders\ReturnTypeSeeder;
use Database\Seeders\ReturnBaseSeeder;
use Database\Seeders\PromotorSeeder;
use Database\Seeders\ReturnRequestStatusSeeder;
use Database\Seeders\RequestTypeSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            
            ModuleTypeSeeder::class,
            PermissionModuleSeeder::class,
            PermissionFunctionSeeder::class,
            PermissionPermissionSeeder::class,
            PermissionPermissionRoleSeeder::class,
            MenuSeeder::class,
            BankSeeder::class,
            CurrencyTypeSeeder::class,
            AccountSeeder::class,
            GroupSeeder::class,
            AccountStatusSeeder::class,
            IntermediarySeeder::class,
            CompanyLevelSeeder::class,
            BankSeparationSeeder::class,
            CompanySeeder::class,
            ClientTypeSeeder::class,
            ClientSeeder::class,
            ReturnTypeSeeder::class,
            ReturnBaseSeeder::class,
            PromotorSeeder::class,
            ReturnRequestStatusSeeder::class,
            RequestTypeSeeder::class,
        ]);
    }
}
