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
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('customer_discounts')->insert([
            'id' => 'D-C-0000000000000002',
            'point' => 100,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('customer_discounts')->insert([
            'id' => 'D-C-0000000000000003',
            'point' => 200,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
