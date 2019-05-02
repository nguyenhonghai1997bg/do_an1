<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Masha',
            'email' => 'masha@gmail.com',
            'password' => bcrypt('masha'),
            'address' => 'Ha noi',
            'phone' => '0123456789',
            'role_id' => DB::table('roles')->select('id')->where('name', 'Manager')->first()->id,
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('user'),
            'address' => 'Ha noi VN',
            'phone' => '0123456789',
            'role_id' => DB::table('roles')->select('id')->where('name', 'User')->first()->id,
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'address' => 'Ha noi VN',
            'phone' => '0123456789',
            'role_id' => DB::table('roles')->select('id')->where('name', 'Admin')->first()->id,
        ]);
    }
}
