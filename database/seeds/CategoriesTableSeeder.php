<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'Áo',
            'slug' => Str::slug('ao'),
            'catalog_id' => DB::table('catalogs')->select('id')->where('name', 'Nam')->first()->id,
        ]);

        DB::table('categories')->insert([
            'name' => 'Quần',
            'slug' => Str::slug('quan'),
            'catalog_id' => DB::table('catalogs')->select('id')->where('name', 'Nam')->first()->id,
        ]);

        DB::table('categories')->insert([
            'name' => 'Áo',
            'slug' => Str::slug('ao'),
            'catalog_id' => DB::table('catalogs')->select('id')->where('slug', 'nu')->first()->id,
        ]);

        DB::table('categories')->insert([
            'name' => 'Mũ',
            'slug' => Str::slug('quan'),
            'catalog_id' => DB::table('catalogs')->select('id')->where('slug', 'nu')->first()->id,
        ]);
    }
}
