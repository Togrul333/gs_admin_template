<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
            $admin =   Admin::create([
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => '88888888',
                'role_id' => 1
            ]);

            $admin->assignRole(1);

            $dev =  Admin::create([
                'name' => 'Developer',
                'email' => 'dev@dev.com',
                'password' => '77777777',
                'role_id' => 2
            ]);

            $dev->assignRole(2);



    }
}
