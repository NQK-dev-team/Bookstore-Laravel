<?php

namespace Database\Seeders;

use App\Models\PhyiscalCopy;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            AuthorSeeder::class,
            BelongToSeeder::class,
            CustomerDiscountSeeder::class,
            DiscountApplyToSeeder::class,
            DiscountSeeder::class,
            EventApplyToSeeder::class,
            EventDiscountSeeder::class,
            FileCopySeeder::class,
            FileOrderContainSeeder::class,
            FileOrderSeeder::class,
            OrderSeeder::class,
            PhysicalOrderContainSeeder::class,
            PhysicalOrderSeeder::class,
            PhysicalCopySeeder::class,
            RatingSeeder::class,
            ReferrerDiscountSeeder::class,
            BookSeeder::class,
        ]);
    }
}
