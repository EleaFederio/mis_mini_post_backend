<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('categories')->insert([
            'category_name' => 'Dairy'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Bread & Bakery'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Beverage'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Frozen Foods'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Crackers & Cookies'
        ]);
    }
}
