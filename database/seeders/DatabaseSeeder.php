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
        // Ensure test user exists
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
            ]
        );

        // Generate 10 random users
        User::factory(10)->create();

        // Call all other seeders
        $this->call([
            JobOpportunitySeeder::class,
            MagazineSeeder::class,
            MemberBadgeTokenSeeder::class,
            NewsSeeder::class,
            PuzzleAchievementSeeder::class,
            PuzzleSeeder::class,
            EventSeeder::class,
        ]);
    }
}