<?php

use Illuminate\Database\Seeder;

class CatalogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('catalogs')->insert([
        	'name' => 'Nam',
        	'slug' => Str::slug('nam')
        ]);

        DB::table('catalogs')->insert([
        	'name' => 'Nữ',
        	'slug' => Str::slug('nu')
        ]);
    }
}
