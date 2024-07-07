<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReferrerDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('referrer_discounts')->insert([
            'id' => 'D-R-0000000000000001',
            'number_of_people' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('referrer_discounts')->insert([
            'id' => 'D-R-0000000000000002',
            'number_of_people' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('referrer_discounts')->insert([
            'id' => 'D-R-0000000000000003',
            'number_of_people' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
