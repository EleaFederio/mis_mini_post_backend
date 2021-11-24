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
        //********** Product Categories **********//
        // https://www.listplanit.com/list-of-categories-for-an-organized-grocery-list/
        DB::table('categories')->insert([
            'category_name' => 'Beverage'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Bread & Bakery'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Snacks'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Canned/Jarred Goods'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Dairy'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Dry/Baking Goods'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Frozen Foods'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Meat'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Produce'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Cleaners'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Paper Goods'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Personal Care'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Electronics'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Utensils'
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Other'
        ]);

        //********** Branches **********//
        DB::table('branches')->insert([
            'branch_name' => 'Legazpi'
        ]);
        DB::table('branches')->insert([
            'branch_name' => 'Daraga'
        ]);
        DB::table('branches')->insert([
            'branch_name' => 'Camalig'
        ]);
        DB::table('branches')->insert([
            'branch_name' => 'Guinobatan'
        ]);
    }
}
