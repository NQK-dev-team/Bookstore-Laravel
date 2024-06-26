<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventDiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event_discounts')->insert([
            'id' => 'D-E-0000000000000001',
            'discount' => 30,
            'start_date' =>  now()->subDays(3),
            'end_date' => now()->addDays(10),
            'apply_for_all_books' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_discounts')->insert([
            'id' => 'D-E-0000000000000002',
            'discount' => 35,
            'start_date' => now()->subDays(1),
            'end_date' =>  now()->addDays(7),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_discounts')->insert([
            'id' => 'D-E-0000000000000003',
            'discount' => 25,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(9),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_discounts')->insert([
            'id' => 'D-E-0000000000000004',
            'discount' => 40,
            'start_date' => now()->subDays(2),
            'end_date' => now()->addDays(7),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_discounts')->insert([
            'id' => 'D-E-0000000000000005',
            'discount' => 20,
            'start_date' => now()->subDays(8),
            'end_date' => now()->addDays(3),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
