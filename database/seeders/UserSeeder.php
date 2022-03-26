<?php

namespace Database\Seeders;

use App\Models\User;
use App\Types\RoleType;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user = User::create([
            'name' => "administrator",
            'email' => "admin@mail.com",
            'password' => Hash::make('123123')
        ]);
        
        $user->assignRole(RoleType::ADMINISTRATOR);

        $user = User::create([
            'name' => "cashier",
            'first_name' => "cashier",
            'last_name' => "cashier",
            'email' => "cashier@mail.com",
            'password' => Hash::make('123123')
        ]);
        
        $user->assignRole(RoleType::CASHIER);

        $user = User::create([
            'name' => "customer",
            'first_name' => "customer",
            'last_name' => "customer",
            'email' => "customer@mail.com",
            'password' => Hash::make('123123')
        ]);
        
        $user->assignRole(RoleType::CUSTOMER);

        Notification::create([
            'user_id' => $user->id,
            'message' => 0,
            'order' => 0
        ]);

    }
}
