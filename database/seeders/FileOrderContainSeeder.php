<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileOrderContainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000001',
            'book_id' => 'B-000000000000000008',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000001',
            'book_id' => 'B-000000000000000001',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000002',
            'book_id' => 'B-000000000000000010',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000002',
            'book_id' => 'B-000000000000000021',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000004',
            'book_id' => 'B-000000000000000008',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000004',
            'book_id' => 'B-000000000000000001',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000005',
            'book_id' => 'B-000000000000000010',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000005',
            'book_id' => 'B-000000000000000021',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000007',
            'book_id' => 'B-000000000000000008',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000007',
            'book_id' => 'B-000000000000000001',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000008',
            'book_id' => 'B-000000000000000010',

        ]);

        DB::table('file_order_contains')->insert([
            'order_id' => 'O-000000000000000008',
            'book_id' => 'B-000000000000000021',

        ]);
    }
}
