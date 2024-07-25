<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            "account_number" => "123456789012",
            "clabe" => "XXXX1234XXXX1234",
            "bank_id" => 1,
            "currency_type_id" => 1,
            "balance" => 315000
        ]);

        Account::create([
            "account_number" => "345141589012",
            "clabe" => "XXXX1234XXXX1234",
            "ava" => "4411",
            "swift" => "2233",
            "bank_id" => 2,
            "currency_type_id" => 2,
            "balance" => 189200
        ]);
    }
}
