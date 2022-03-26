<?php

namespace Database\Seeders;

use App\Types\RoleType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => RoleType::ADMINISTRATOR]);
        Role::create(['name' => RoleType::CASHIER]);
        Role::create(['name' => RoleType::CUSTOMER]);
    }
}