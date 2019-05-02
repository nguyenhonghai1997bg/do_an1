<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('roles')->insert([
            'name' => 'User',
            'slug' => Str::slug('user', '-')
        ]);
        
        DB::table('roles')->insert([
            'name' => 'Admin',
            'slug' => Str::slug('admin', '-')
        ]);

        DB::table('roles')->insert([
            'name' => 'Manager',
            'slug' => Str::slug('manager', '-')
        ]);
    }
}
