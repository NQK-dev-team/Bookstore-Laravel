<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            'name' => 'Alan Forbes',
            'book_id' => 'B-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Mark Manson',
            'book_id' => 'B-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Michiel Werbrouck',
            'book_id' => 'B-000000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Douglas Adams',
            'book_id' => 'B-000000000000000004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Herbert George Wells',
            'book_id' => 'B-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Jane Austen',
            'book_id' => 'B-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Harper Lee',
            'book_id' => 'B-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Paulo Coelho',
            'book_id' => 'B-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Margaret Atwood',
            'book_id' => 'B-000000000000000009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Yuval Noah Harari',
            'book_id' => 'B-000000000000000010',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Bram Stoker',
            'book_id' => 'B-000000000000000011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Gabriel Garcia Marquez',
            'book_id' => 'B-000000000000000012',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Andy Weir',
            'book_id' => 'B-000000000000000013',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'John Green',
            'book_id' => 'B-000000000000000014',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Chinua Achebe',
            'book_id' => 'B-000000000000000015',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Agatha Christie',
            'book_id' => 'B-000000000000000016',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Frank Herbert',
            'book_id' => 'B-000000000000000017',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'John Ronald Reuel Tolkien',
            'book_id' => 'B-000000000000000018',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Margaret Atwood',
            'book_id' => 'B-000000000000000019',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Yuval Noah Harari',
            'book_id' => 'B-000000000000000020',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Alexandre Dumas',
            'book_id' => 'B-000000000000000021',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Mary Shelley',
            'book_id' => 'B-000000000000000022',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Douglas Adams',
            'book_id' => 'B-000000000000000023',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'George Orwell',
            'book_id' => 'B-000000000000000024',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Arundhati Roy',
            'book_id' => 'B-000000000000000025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Gaia Sol',
            'book_id' => 'B-000000000000000026',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Laurence Kotlikoff',
            'book_id' => 'B-000000000000000027',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Kyle Mills',
            'book_id' => 'B-000000000000000028',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Adam Shoalts',
            'book_id' => 'B-000000000000000029',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Mitch Albom',
            'book_id' => 'B-000000000000000030',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'name' => 'Michiel Werbrouck',
            'book_id' => 'B-000000000000000031',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
