<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customer_discounts')->insert([
            'id' => 'D-C-0000000000000001',
            'point' => 50,
            'discount' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('customer_discounts')->insert([
            'id' => 'D-C-0000000000000002',
            'point' => 100,
            'discount' => 7,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('customer_discounts')->insert([
            'id' => 'D-C-0000000000000003',
            'point' => 200,
            'discount' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
