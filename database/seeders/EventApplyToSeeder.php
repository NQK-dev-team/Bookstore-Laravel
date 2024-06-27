<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventApplyToSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000002',
            'book_id' => 'B-000000000000000004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000002',
            'book_id' => 'B-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000002',
            'book_id' => 'B-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000002',
            'book_id' => 'B-000000000000000012',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000002',
            'book_id' => 'B-000000000000000013',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000002',
            'book_id' => 'B-000000000000000017',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000003',
            'book_id' => 'B-000000000000000010',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000003',
            'book_id' => 'B-000000000000000020',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000004',
            'book_id' => 'B-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000012',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000013',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000017',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000019',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000021',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('event_applies_to')->insert([
            'event_discount_id' => 'D-E-0000000000000005',
            'book_id' => 'B-000000000000000024',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
