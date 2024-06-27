<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PhysicalCopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000001',
            'price' => '29.99',
            'quantity' => '2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000002',
            'price' => '39.99',
            'quantity' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000003',
            'price' => '49.99',
            'quantity' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000004',
            'price' => '59.99',
            'quantity' => "32",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000005',
            'price' => '15.99',
            'quantity' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000006',
            'price' => '29.99',
            'quantity' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000007',
            'price' => '39.99',
            'quantity' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000008',
            'price' => '49.99',
            'quantity' => '18',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000009',
            'price' => '59.99',
            'quantity' => "11",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000010',
            'price' => '15.99',
            'quantity' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000011',
            'price' => '29.99',
            'quantity' => '25',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000012',
            'price' => '39.99',
            'quantity' => '19',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000013',
            'price' => '49.99',
            'quantity' => '4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000014',
            'price' => '59.99',
            'quantity' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000015',
            'price' => '15.99',
            'quantity' => '20',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000016',
            'price' => '29.99',
            'quantity' => '17',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000017',
            'price' => '39.99',
            'quantity' => '21',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000018',
            'price' => '49.99',
            'quantity' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000019',
            'price' => '59.99',
            'quantity' => "10",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000020',
            'price' => '15.99',
            'quantity' => '7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000021',
            'price' => '29.99',
            'quantity' => '15',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000022',
            'price' => '39.99',
            'quantity' => '25',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000023',
            'price' => '49.99',
            'quantity' => "14",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000024',
            'price' => '59.99',
            'quantity' => '12',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000025',
            'price' => '15.99',
            'quantity' => '17',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000026',
            'price' => '29.99',
            'quantity' => '24',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000027',
            'price' => '39.99',
            'quantity' => '14',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000028',
            'price' => '49.99',
            'quantity' => '19',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000029',
            'price' => '59.99',
            'quantity' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000030',
            'price' => '15.99',
            'quantity' => "15",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('physical_copies')->insert([
            'id' => 'B-000000000000000031',
            'price' => '29.99',
            'quantity' => '18',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
