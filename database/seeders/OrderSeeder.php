<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'status' => true,
            'total_price' => 253.92,
            'total_discount' => 115.95,
            'customer_id' => 'U-C-0000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'status' => true,
            'total_price' => 19.19,
            'total_discount' => 8.79,
            'customer_id' => 'U-C-0000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'total_price' => 400.9,
            'total_discount' => 230.98,
            'customer_id' => 'U-C-0000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'status' => true,
            'total_price' => 259.11,
            'total_discount' => 110.76,
            'customer_id' => 'U-C-0000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'status' => true,
            'total_price' => 19.59,
            'total_discount' => 8.39,
            'customer_id' => 'U-C-0000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'total_price' => 409.08,
            'total_discount' => 222.8,
            'customer_id' => 'U-C-0000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'status' => true,
            'total_price' => 259.11,
            'total_discount' => 110.76,
            'customer_id' => 'U-C-0000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'status' => true,
            'total_price' => 19.59,
            'total_discount' => 8.39,
            'customer_id' => 'U-C-0000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('orders')->insert([
            'id' => IdGenerator::generate(['table' => 'orders', 'length' => 20, 'prefix' => 'O-']),
            'total_price' => 409.08,
            'total_discount' => 222.8,
            'customer_id' => 'U-C-0000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
