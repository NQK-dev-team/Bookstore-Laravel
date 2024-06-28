<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiscountApplyToSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000001',
            'discount_id' => 'D-E-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000001',
            'discount_id' => 'D-E-0000000000000002',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000001',
            'discount_id' => 'D-E-0000000000000004',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000001',
            'discount_id' => 'D-R-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000002',
            'discount_id' => 'D-E-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000002',
            'discount_id' => 'D-R-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000003',
            'discount_id' => 'D-E-0000000000000002',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000003',
            'discount_id' => 'D-E-0000000000000004',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000003',
            'discount_id' => 'D-R-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000004',
            'discount_id' => 'D-E-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000004',
            'discount_id' => 'D-E-0000000000000002',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000004',
            'discount_id' => 'D-E-0000000000000004',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000005',
            'discount_id' => 'D-E-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000006',
            'discount_id' => 'D-E-0000000000000002',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000006',
            'discount_id' => 'D-E-0000000000000004',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000007',
            'discount_id' => 'D-E-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000007',
            'discount_id' => 'D-E-0000000000000002',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000007',
            'discount_id' => 'D-E-0000000000000004',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000008',
            'discount_id' => 'D-E-0000000000000001',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000009',
            'discount_id' => 'D-E-0000000000000002',
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('discount_applies_to')->insert([
            'order_id' => 'O-000000000000000009',
            'discount_id' => 'D-E-0000000000000004',
            'updated_at' => now(),
            'created_at' => now(),
        ]);
    }
}
