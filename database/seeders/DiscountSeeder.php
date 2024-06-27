<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' => 'D-C-', 'reset_on_prefix_change' => true]),
            'name' => 'Customer discount level 1',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-C-', 'reset_on_prefix_change' => true]),
            'name' => 'Customer discount level 2',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-C-', 'reset_on_prefix_change' => true]),
            'name' => 'Customer discount level 3',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-R-', 'reset_on_prefix_change' => true]),
            'name' => 'Referrer discount level 1',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-R-', 'reset_on_prefix_change' => true]),
            'name' => 'Referrer discount level 2',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-R-', 'reset_on_prefix_change' => true]),
            'name' => 'Referrer discount level 3',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-E-', 'reset_on_prefix_change' => true]),
            'name' => 'Black Friday',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-E-', 'reset_on_prefix_change' => true]),
            'name' => 'Science Fair',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-E-', 'reset_on_prefix_change' => true]),
            'name' => 'History Lesson',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-E-', 'reset_on_prefix_change' => true]),
            'name' => 'Children\'s story',
            'updated_at' => now(),
            'created_at' => now()
        ]);

        DB::table('discounts')->insert([
            'id' => IdGenerator::generate(['table' => 'discounts', 'length' => 20, 'prefix' =>'D-E-', 'reset_on_prefix_change' => true]),
            'name' => 'Fiction day',
            'updated_at' => now(),
            'created_at' => now()
        ]);
    }
}
