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
            'author_id' => 'C-000000000000000015',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000001',
            'author_id' => 'C-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000002',
            'author_id' => 'C-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000002',
            'author_id' => 'C-000000000000000012',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000002',
            'author_id' => 'C-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000003',
            'author_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000003',
            'author_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000004',
            'author_id' => 'C-000000000000000004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000004',
            'author_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000005',
            'author_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000005',
            'author_id' => 'C-000000000000000014',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000006',
            'author_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000007',
            'author_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000008',
            'author_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000009',
            'author_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000010',
            'author_id' => 'C-000000000000000011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000011',
            'author_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000012',
            'author_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000013',
            'author_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000014',
            'author_id' => 'C-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000015',
            'author_id' => 'C-000000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000016',
            'author_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000017',
            'author_id' => 'C-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000018',
            'author_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000019',
            'author_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000020',
            'author_id' => 'C-000000000000000011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000021',
            'author_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000022',
            'author_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-0000000000000000023',
            'author_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-0000000000000000024',
            'author_id' => 'C-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000025',
            'author_id' => 'C-000000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000026',
            'author_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000027',
            'author_id' => 'C-000000000000000013',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000028',
            'author_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000029',
            'author_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000030',
            'author_id' => 'C-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('belongs_to')->insert([
            'book_id' => 'B-000000000000000031',
            'author_id' => 'C-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
