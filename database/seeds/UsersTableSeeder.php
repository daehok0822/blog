<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::truncate();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@blog.test',
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => bcrypt('admin'), // password
            'isAdmin' => true,
            'remember_token' => '1234',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        DB::table('users')->insert([
            'name' => '길동이',
            'email' => 'gildong@blog.test',
            'email_verified_at' => date("Y-m-d H:i:s"),
            'password' => bcrypt('gildong') , // password
            'isAdmin' => false,
            'remember_token' => '1234',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}
