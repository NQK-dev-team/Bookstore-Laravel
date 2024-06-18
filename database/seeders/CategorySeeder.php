<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Fiction',
            'description' => 'Fiction books are imaginative narratives that take readers into invented worlds, offering an entertaining escape into diverse emotions and experiences.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Fantasy',
            'description' => 'Fantasy books weave magical tales, transporting readers to enchanting worlds filled with mythical creatures and extraordinary adventures.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Mystery',
            'description' => 'Mystery books captivate with suspenseful tales, inviting readers to unravel puzzles and navigate thrilling plots, often featuring detectives and unexpected twists.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Thriller',
            'description' => 'Thriller books offer gripping plots, high stakes, and relentless suspense, delivering an edge-of-the-seat reading experience.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Romance',
            'description' => 'Romance books delve into love and relationships, weaving passionate tales of connection and heartwarming journeys to find true love.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Historical Fiction',
            'description' => 'Historical fiction brings the past to life, blending real history with fictional characters and events, creating captivating stories set against rich historical backdrops.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Science Fiction',
            'description' => 'Science fiction envisions futuristic worlds, probing into advanced technologies, extraterrestrial encounters, and the limitless possibilities of the universe, sparking curiosity and creativity.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Nonfiction',
            'description' => 'Nonfiction books provide factual insights and real-world knowledge across diverse subjects, offering readers an opportunity to expand their understanding of the world.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Biography',
            'description' => 'Biographies offer firsthand insights into the lives, achievements, and challenges of real individuals, providing readers with a glimpse into notable figures\' personal journeys.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Memoir',
            'description' => 'Memoirs share personal experiences and emotions, offering an intimate journey through the author\'s life, capturing significant moments and unique perspectives.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'History',
            'description' => 'History books chronicle past events and societal changes, offering insights into the triumphs and challenges of human development over time.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Self-help',
            'description' => 'Self-help books empower readers with practical tools and insights for personal development, offering actionable advice for positive life changes and growth.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Business',
            'description' => 'Business books delve into the principles, challenges, and trends of the corporate world, offering valuable insights for individuals navigating the dynamic landscape of business and entrepreneurship.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Children\'s books',
            'description' => 'Children\'s books captivate young readers with imaginative stories, vibrant illustrations, and valuable life lessons, fostering a love for reading and nurturing creativity.',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('categories')->insert([
            'id' => IdGenerator::generate(['table' => 'categories', 'length' => 20, 'prefix' => 'C-']),
            'name' => 'Tutorial',
            'description' => 'Tutorials offer step-by-step guidance for learners to acquire new skills or knowledge in a hands-on and practical manner.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
