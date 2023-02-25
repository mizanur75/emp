<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            'first_name' => 'Super',
            'Last_name' => 'Admin',
            'email' => 'admin@email.com',
            'status' => 'Active',
            'password' => bcrypt('11111111'),
        ]);
        DB::table('users')->insert([
            'role_id' => 2,
            'first_name' => 'Md',
            'Last_name' => 'Employee',
            'email' => 'employee@email.com',
            'status' => 'Active',
            'password' => bcrypt('22222222'),
        ]);
    }
}
