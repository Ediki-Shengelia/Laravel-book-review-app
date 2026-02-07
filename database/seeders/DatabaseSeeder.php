<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

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
        \App\Models\Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            \App\Models\Review::factory()->count($numReviews)
                ->good()
                ->for($book)
                ->create();
        });
        \App\Models\Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            \App\Models\Review::factory()->count($numReviews)
                ->average()
                ->for($book)
                ->create();
        });
        \App\Models\Book::factory(33)->create()->each(function ($book) {
            $numReviews = random_int(5, 30);
            \App\Models\Review::factory()->count($numReviews)
                ->bad()
                ->for($book)
                ->create();
        });
    }
}
