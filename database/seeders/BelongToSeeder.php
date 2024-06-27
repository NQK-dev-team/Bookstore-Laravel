<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BelongToSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000001',
            'category_id' => 'C-000000000000000015',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000001',
            'category_id' => 'C-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000002',
            'category_id' => 'C-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000002',
            'category_id' => 'C-000000000000000012',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000002',
            'category_id' => 'C-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000003',
            'category_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000003',
            'category_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000004',
            'category_id' => 'C-000000000000000004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000004',
            'category_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000005',
            'category_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000005',
            'category_id' => 'C-000000000000000014',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000006',
            'category_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000007',
            'category_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000008',
            'category_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000009',
            'category_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000010',
            'category_id' => 'C-000000000000000011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000011',
            'category_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000012',
            'category_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000013',
            'category_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000014',
            'category_id' => 'C-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000015',
            'category_id' => 'C-000000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000016',
            'category_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000017',
            'category_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000018',
            'category_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000019',
            'category_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000020',
            'category_id' => 'C-000000000000000011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000021',
            'category_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000022',
            'category_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000023',
            'category_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000024',
            'category_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000025',
            'category_id' => 'C-000000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000026',
            'category_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000027',
            'category_id' => 'C-000000000000000013',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000028',
            'category_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000029',
            'category_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000030',
            'category_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000031',
            'category_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
