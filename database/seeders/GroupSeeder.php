<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Group;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            "name" => "Grupo 1"
        ]);
        Group::create([
            "name" => "Grupo 2"
        ]);
        Group::create([
            "name" => "Grupo 3"
        ]);
    }
}
