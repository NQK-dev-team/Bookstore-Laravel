<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhysicalOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('physical_orders')->insert([
            'id' => 'O-000000000000000001',
            'address' => '211 Ly Thuong Kiet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_orders')->insert([
            'id' => 'O-000000000000000003',
            'address' => '211 Ly Thuong Kiet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_orders')->insert([
            'id' => 'O-000000000000000004',
            'address' => '211 Ly Thuong Kiet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_orders')->insert([
            'id' => 'O-000000000000000006',
            'address' => '211 Ly Thuong Kiet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_orders')->insert([
            'id' => 'O-000000000000000007',
            'address' => '211 Ly Thuong Kiet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_orders')->insert([
            'id' => 'O-000000000000000009',
            'address' => '211 Ly Thuong Kiet',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
