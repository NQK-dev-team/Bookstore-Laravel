<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FileCopySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000001',
            'price' => '13.99',
            'path' => 'files/BOOK1/The+Joy+of+PHP.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000002',
            'price' => '13.99',
            'path' => 'files/BOOK2/Models+Attract+Women+Through+Honesty.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000003',
            'price' => '13.99',
            'path' => 'files/BOOK3/Lord+of+Goblins%2C+Vol.+1+Definitive+Edition+(Lord+of+Goblins).pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000004',
            'price' => '13.99',
            'path' => "files/BOOK4/The+Hitchhiker's+Guide+to+the+Galaxy.pdf",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000005',
            'price' => '13.99',
            'path' => 'files/BOOK5/The+Time+Machine.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000006',
            'price' => '13.99',
            'path' => 'files/BOOK6/Pride+and+Prejudice.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000007',
            'price' => '13.99',
            'path' => 'files/BOOK7/To+Kill+a+Mockingbird.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000008',
            'price' => '13.99',
            'path' => 'files/BOOK8/The+Alchemist.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000009',
            'price' => '13.99',
            'path' => "files/BOOK9/The+Handmaid's+Tale.pdf",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000010',
            'price' => '13.99',
            'path' => 'files/BOOK10/Sapiens+A+Brief+History+of+Humankind.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000011',
            'price' => '13.99',
            'path' => 'files/BOOK11/Dracula.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000012',
            'price' => '13.99',
            'path' => 'files/BOOK12/One+Hundred+Years+of+Solitude.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000013',
            'price' => '13.99',
            'path' => 'files/BOOK13/The+Martian.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000014',
            'price' => '13.99',
            'path' => 'files/BOOK14/The+Fault+in+Our+Stars.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000015',
            'price' => '13.99',
            'path' => 'files/BOOK15/Things+Fall+Apart.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000016',
            'price' => '13.99',
            'path' => 'files/BOOK16/Murder+on+the+Orient+Express.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000017',
            'price' => '13.99',
            'path' => 'files/BOOK17/Dune.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000018',
            'price' => '13.99',
            'path' => 'files/BOOK18/The+Lord+of+the+Rings.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000019',
            'price' => '13.99',
            'path' => "files/BOOK19/The+Handmaid's+Tale.pdf",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000020',
            'price' => '13.99',
            'path' => 'files/BOOK20/Sapiens+A+Brief+History+of+Humankind.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000021',
            'price' => '13.99',
            'path' => 'files/BOOK21/The+Count+of+Monte+Cristo.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000022',
            'price' => '13.99',
            'path' => 'files/BOOK22/Frankenstein.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000023',
            'price' => '13.99',
            'path' => "files/BOOK23/The+Hitchhiker's+Guide+to+the+Galaxy.pdf",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000024',
            'price' => '13.99',
            'path' => 'files/BOOK24/1984.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000025',
            'price' => '13.99',
            'path' => 'files/BOOK25/The+God+of+Small+Things.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000026',
            'price' => '13.99',
            'path' => 'files/BOOK26/Echoes+of+Asgard.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000027',
            'price' => '13.99',
            'path' => 'files/BOOK27/Money+Magic.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000028',
            'price' => '13.99',
            'path' => 'files/BOOK28/Code+Red.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000029',
            'price' => '13.99',
            'path' => 'files/BOOK29/Whisper+in+the+Wilds.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000030',
            'price' => '13.99',
            'path' => "files/BOOK30/The+Girl+with+the+Timekeeper's+Heart.pdf",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('file_copies')->insert([
            'id' => 'B-000000000000000031',
            'price' => '13.99',
            'path' => 'files/BOOK31/Lord+of+Goblins%2C+Vol.+2.pdf',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
