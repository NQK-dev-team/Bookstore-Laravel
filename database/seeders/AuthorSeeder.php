<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Alan Forbes',
            'book_id' => 'B-000000000000000001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Mark Manson',
            'book_id' => 'B-000000000000000002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Michiel Werbrouck',
            'book_id' => 'B-000000000000000003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Douglas Adams',
            'book_id' => 'B-000000000000000004',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Herbert George Wells',
            'book_id' => 'B-000000000000000005',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Jane Austen',
            'book_id' => 'B-000000000000000006',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Harper Lee',
            'book_id' => 'B-000000000000000007',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Paulo Coelho',
            'book_id' => 'B-000000000000000008',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Margaret Atwood',
            'book_id' => 'B-000000000000000009',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Yuval Noah Harari',
            'book_id' => 'B-000000000000000010',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Bram Stoker',
            'book_id' => 'B-000000000000000011',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Gabriel Garcia Marquez',
            'book_id' => 'B-000000000000000012',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Andy Weir',
            'book_id' => 'B-000000000000000013',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'John Green',
            'book_id' => 'B-000000000000000014',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Chinua Achebe',
            'book_id' => 'B-000000000000000015',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Agatha Christie',
            'book_id' => 'B-000000000000000016',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Frank Herbert',
            'book_id' => 'B-000000000000000017',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'John Ronald Reuel Tolkien',
            'book_id' => 'B-000000000000000018',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Margaret Atwood',
            'book_id' => 'B-000000000000000019',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Yuval Noah Harari',
            'book_id' => 'B-000000000000000020',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Alexandre Dumas',
            'book_id' => 'B-000000000000000021',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Mary Shelley',
            'book_id' => 'B-000000000000000022',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Douglas Adams',
            'book_id' => 'B-000000000000000023',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'George Orwell',
            'book_id' => 'B-000000000000000024',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Arundhati Roy',
            'book_id' => 'B-000000000000000025',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Gaia Sol',
            'book_id' => 'B-000000000000000026',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Laurence Kotlikoff',
            'book_id' => 'B-000000000000000027',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Kyle Mills',
            'book_id' => 'B-000000000000000028',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Adam Shoalts',
            'book_id' => 'B-000000000000000029',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Mitch Albom',
            'book_id' => 'B-000000000000000030',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('authors')->insert([
            'id' => IdGenerator::generate(['table' => 'authors', 'length' => 20, 'prefix' => 'A-']),
            'name' => 'Michiel Werbrouck',
            'book_id' => 'B-000000000000000031',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
