<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhysicalOrderContainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000001',
            'book_id' => 'B-000000000000000004',
            'amount' => 1,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000001',
            'book_id' => 'B-000000000000000005',
            'amount' => 2,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000001',
            'book_id' => 'B-000000000000000006',
            'amount' => 3,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000001',
            'book_id' => 'B-000000000000000007',
            'amount' => 1,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000001',
            'book_id' => 'B-000000000000000021',
            'amount' => 4,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000003',
            'book_id' => 'B-000000000000000004',
            'amount' => 10,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000003',
            'book_id' => 'B-000000000000000005',
            'amount' => 2,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000004',
            'book_id' => 'B-000000000000000004',
            'amount' => 1,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000004',
            'book_id' => 'B-000000000000000005',
            'amount' => 2,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000004',
            'book_id' => 'B-000000000000000006',
            'amount' => 3,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000004',
            'book_id' => 'B-000000000000000007',
            'amount' => 1,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000004',
            'book_id' => 'B-000000000000000021',
            'amount' => 4,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000006',
            'book_id' => 'B-000000000000000004',
            'amount' => 10,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000006',
            'book_id' => 'B-000000000000000005',
            'amount' => 2,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000007',
            'book_id' => 'B-000000000000000004',
            'amount' => 1,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000007',
            'book_id' => 'B-000000000000000005',
            'amount' => 2,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000007',
            'book_id' => 'B-000000000000000006',
            'amount' => 3,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000007',
            'book_id' => 'B-000000000000000007',
            'amount' => 1,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000007',
            'book_id' => 'B-000000000000000021',
            'amount' => 4,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000009',
            'book_id' => 'B-000000000000000004',
            'amount' => 10,
            'updated_at' => now(),
            'created_at' => now(),
        ]);

        DB::table('physical_order_contains')->insert([
            'order_id' => 'O-000000000000000009',
            'book_id' => 'B-000000000000000005',
            'amount' => 2,
            'updated_at' => now(),
            'created_at' => now(),
        ]);
    }
}
