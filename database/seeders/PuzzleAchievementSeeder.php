<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PuzzleAchievement;

class PuzzleAchievementSeeder extends Seeder
{
    public function run()
    {
        $achievements = [
            [
                'name' => 'First Steps',
                'slug' => 'first-steps',
                'description' => 'Complete your first puzzle',
                'icon' => 'fas fa-shoe-prints',
                'criteria' => ['type' => 'total_score', 'threshold' => 1],
                'points' => 10,
                'rarity' => 'common',
            ],
            [
                'name' => 'Puzzle Master',
                'slug' => 'puzzle-master',
                'description' => 'Complete 10 puzzles',
                'icon' => 'fas fa-crown',
                'criteria' => ['type' => 'total_score', 'threshold' => 10],
                'points' => 50,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Perfect Score',
                'slug' => 'perfect-score',
                'description' => 'Get a perfect score on any puzzle',
                'icon' => 'fas fa-star',
                'criteria' => ['type' => 'perfect_score'],
                'points' => 100,
                'rarity' => 'epic',
            ],
            [
                'name' => 'Speed Demon',
                'slug' => 'speed-demon',
                'description' => 'Complete a timed puzzle with more than 50% time remaining',
                'icon' => 'fas fa-bolt',
                'criteria' => ['type' => 'speed_demon', 'seconds' => 30],
                'points' => 75,
                'rarity' => 'rare',
            ],
            [
                'name' => 'Weekly Warrior',
                'slug' => 'weekly-warrior',
                'description' => 'Complete puzzles 7 days in a row',
                'icon' => 'fas fa-fire',
                'criteria' => ['type' => 'streak', 'days' => 7],
                'points' => 150,
                'rarity' => 'epic',
            ],
            [
                'name' => 'African Scholar',
                'slug' => 'african-scholar',
                'description' => 'Achieve 90%+ on 5 different heritage puzzles',
                'icon' => 'fas fa-graduation-cap',
                'criteria' => ['type' => 'mastery', 'count' => 5],
                'points' => 200,
                'rarity' => 'legendary',
            ],
            [
                'name' => 'Map Explorer',
                'slug' => 'map-explorer',
                'description' => 'Complete all country puzzles',
                'icon' => 'fas fa-map',
                'criteria' => ['type' => 'category_mastery', 'category' => 'country'],
                'points' => 300,
                'rarity' => 'legendary',
            ],
        ];
        
        foreach ($achievements as $achievement) {
            PuzzleAchievement::updateOrCreate(
                ['slug' => $achievement['slug']],
                $achievement
            );
        }
    }
}