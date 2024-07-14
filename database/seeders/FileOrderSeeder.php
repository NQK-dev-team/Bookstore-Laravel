<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FileOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
