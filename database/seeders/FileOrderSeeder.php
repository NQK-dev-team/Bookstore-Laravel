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
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000002',
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000003',
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000004',
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000005',
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000006',
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000007',
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000008',
        ]);

        DB::table('file_orders')->insert([
            'id' => 'O-000000000000000009',
        ]);
    }
}
