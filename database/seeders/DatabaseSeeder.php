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
            BookSeeder::class,
            AuthorSeeder::class,
            BelongToSeeder::class,

            FileCopySeeder::class,
            PhysicalCopySeeder::class,

            OrderSeeder::class,
            FileOrderSeeder::class,
            FileOrderContainSeeder::class,
            PhysicalOrderSeeder::class,
            PhysicalOrderContainSeeder::class,

            DiscountSeeder::class,
            CustomerDiscountSeeder::class,
            ReferrerDiscountSeeder::class,
            EventDiscountSeeder::class,
            EventApplyToSeeder::class,
            DiscountApplyToSeeder::class,
        ]);
    }
}
