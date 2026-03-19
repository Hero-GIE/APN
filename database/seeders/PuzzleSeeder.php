<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Puzzle;
use App\Models\PuzzleCategory;
use App\Models\PuzzleQuestion;
use App\Models\PuzzleAchievement;
use Illuminate\Support\Str;

class PuzzleSeeder extends Seeder
{
    public function run()
    {
        // Create categories
        $categories = [
            [
                'name' => 'Countries',
                'slug' => 'countries',
                'description' => 'Test your knowledge of African countries',
                'icon' => 'fas fa-map',
                'color' => '#3b82f6',
                'display_order' => 1,
            ],
            [
                'name' => 'Capitals',
                'slug' => 'capitals',
                'description' => 'African capital cities quiz',
                'icon' => 'fas fa-city',
                'color' => '#10b981',
                'display_order' => 2,
            ],
            [
                'name' => 'Flags',
                'slug' => 'flags',
                'description' => 'Match flags to countries',
                'icon' => 'fas fa-flag',
                'color' => '#f59e0b',
                'display_order' => 3,
            ],
            [
                'name' => 'Heritage',
                'slug' => 'heritage',
                'description' => 'African culture, history and heritage',
                'icon' => 'fas fa-landmark',
                'color' => '#8b5cf6',
                'display_order' => 4,
            ],
        ];

        foreach ($categories as $cat) {
            PuzzleCategory::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        // Create achievements
        $achievements = [
            [
                'name' => 'First Steps',
                'slug' => 'first-steps',
                'description' => 'Complete your first puzzle',
                'icon' => 'fas fa-shoe-prints',
                'criteria' => json_encode(['type' => 'total_score', 'threshold' => 1]),
                'points' => 10,
                'rarity' => 'common',
            ],
            [
                'name' => 'Perfect Score',
                'slug' => 'perfect-score',
                'description' => 'Get a perfect score on any puzzle',
                'icon' => 'fas fa-star',
                'criteria' => json_encode(['type' => 'perfect_score']),
                'points' => 50,
                'rarity' => 'rare',
            ],
            [
                'name' => 'African Scholar',
                'slug' => 'african-scholar',
                'description' => 'Complete 5 different puzzles with 80%+ score',
                'icon' => 'fas fa-graduation-cap',
                'criteria' => json_encode(['type' => 'mastery', 'count' => 5]),
                'points' => 100,
                'rarity' => 'epic',
            ],
        ];

        foreach ($achievements as $ach) {
            PuzzleAchievement::updateOrCreate(
                ['slug' => $ach['slug']],
                $ach
            );
        }

        // Create puzzles
        $puzzles = [
            // African Capitals Quiz
            [
                'title' => 'African Capitals Challenge',
                'slug' => 'african-capitals-challenge',
                'short_description' => 'Test your knowledge of African capital cities',
                'description' => 'How well do you know the capitals of Africa? This quiz will challenge your knowledge of all 54 African countries and their capital cities.',
                'type' => 'capital_quiz',
                'difficulty' => 'intermediate',
                'content' => json_encode(['format' => 'multiple_choice']),
                'settings' => json_encode(['time_limit' => 300, 'attempts' => 3]),
                'base_points' => 100,
                'bonus_points' => 20,
                'featured_image' => '/images/puzzles/africa-map.jpg',
                'thumbnail' => '/images/puzzles/africa-map-thumb.jpg',
                'time_limit' => 300,
                'attempts_allowed' => 3,
                'hints_allowed' => 2,
                'is_active' => true,
                'is_featured' => true,
                'is_timed' => true,
                'category_id' => 2, // Capitals
            ],
            // West African Countries
            [
                'title' => 'West African Countries',
                'slug' => 'west-african-countries',
                'short_description' => 'Identify countries in West Africa',
                'description' => 'Test your knowledge of West African countries, their locations, and key facts.',
                'type' => 'country_puzzle',
                'difficulty' => 'beginner',
                'content' => json_encode(['format' => 'multiple_choice']),
                'settings' => json_encode(['time_limit' => null, 'attempts' => 5]),
                'base_points' => 80,
                'bonus_points' => 10,
                'featured_image' => '/images/puzzles/west-africa.jpg',
                'thumbnail' => '/images/puzzles/west-africa-thumb.jpg',
                'time_limit' => null,
                'attempts_allowed' => 5,
                'hints_allowed' => 3,
                'is_active' => true,
                'is_featured' => false,
                'is_timed' => false,
                'category_id' => 1, 
            ],
            // African Flags Quiz
            [
                'title' => 'African Flags Quiz',
                'slug' => 'african-flags-quiz',
                'short_description' => 'Match flags to their countries',
                'description' => 'Can you identify all 54 African flags? Test your knowledge with this challenging flag quiz.',
                'type' => 'flag_match',
                'difficulty' => 'advanced',
                'content' => json_encode(['format' => 'image_match']),
                'settings' => json_encode(['time_limit' => 600, 'attempts' => 3]),
                'base_points' => 150,
                'bonus_points' => 30,
                'featured_image' => '/images/puzzles/african-flag.jpeg',
                'thumbnail' => '/images/puzzles/african-flag.jepg',
                'time_limit' => 600,
                'attempts_allowed' => 3,
                'hints_allowed' => 1,
                'is_active' => true,
                'is_featured' => true,
                'is_timed' => true,
                'category_id' => 3, // Flags
            ],
        ];

        foreach ($puzzles as $puzzleData) {
            $puzzle = Puzzle::updateOrCreate(
                ['slug' => $puzzleData['slug']],
                $puzzleData
            );

            // Add questions for each puzzle
            if ($puzzle->slug == 'african-capitals-challenge') {
                $questions = [
                    [
                        'question' => 'What is the capital of Ghana?',
                        'options' => json_encode(['Accra', 'Kumasi', 'Tamale', 'Cape Coast']),
                        'correct_answer' => 'Accra',
                        'explanation' => 'Accra is the capital and largest city of Ghana, located on the Atlantic coast.',
                        'fun_fact' => 'Accra means "ants" in the local Ga language!',
                        'points' => 10,
                        'order' => 1,
                    ],
                    [
                        'question' => 'What is the capital of Nigeria?',
                        'options' => json_encode(['Lagos', 'Abuja', 'Kano', 'Ibadan']),
                        'correct_answer' => 'Abuja',
                        'explanation' => 'Abuja became the capital of Nigeria in 1991, replacing Lagos.',
                        'fun_fact' => 'Abuja was purpose-built as the capital city in the 1980s.',
                        'points' => 10,
                        'order' => 2,
                    ],
                    [
                        'question' => 'What is the capital of Kenya?',
                        'options' => json_encode(['Mombasa', 'Nairobi', 'Kisumu', 'Nakuru']),
                        'correct_answer' => 'Nairobi',
                        'explanation' => 'Nairobi is the capital and largest city of Kenya.',
                        'fun_fact' => 'Nairobi is known as the "Green City in the Sun".',
                        'points' => 10,
                        'order' => 3,
                    ],
                    [
                        'question' => 'What is the capital of South Africa?',
                        'options' => json_encode(['Cape Town', 'Pretoria', 'Bloemfontein', 'All of the above']),
                        'correct_answer' => 'All of the above',
                        'explanation' => 'South Africa has three capitals: Pretoria (executive), Cape Town (legislative), and Bloemfontein (judicial).',
                        'fun_fact' => 'South Africa is the only country with three capital cities!',
                        'points' => 15,
                        'order' => 4,
                    ],
                    [
                        'question' => 'What is the capital of Egypt?',
                        'options' => json_encode(['Alexandria', 'Cairo', 'Giza', 'Luxor']),
                        'correct_answer' => 'Cairo',
                        'explanation' => 'Cairo is the capital and largest city of Egypt.',
                        'fun_fact' => 'Cairo means "The Vanquisher" or "The Triumphant" in Arabic.',
                        'points' => 10,
                        'order' => 5,
                    ],
                    [
                        'question' => 'What is the capital of Morocco?',
                        'options' => json_encode(['Casablanca', 'Rabat', 'Marrakesh', 'Fes']),
                        'correct_answer' => 'Rabat',
                        'explanation' => 'Rabat is the capital of Morocco, located on the Atlantic coast.',
                        'fun_fact' => 'Many people think Casablanca is the capital because of the famous movie!',
                        'points' => 10,
                        'order' => 6,
                    ],
                ];

                foreach ($questions as $q) {
                    $q['puzzle_id'] = $puzzle->id;
                    PuzzleQuestion::updateOrCreate(
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => $q['question']
                        ],
                        $q
                    );
                }
            }

            if ($puzzle->slug == 'west-african-countries') {
                $questions = [
                    [
                        'question' => 'Which of these countries is in West Africa?',
                        'options' => json_encode(['Ethiopia', 'Ghana', 'Kenya', 'Tanzania']),
                        'correct_answer' => 'Ghana',
                        'explanation' => 'Ghana is located in West Africa, while the others are in East Africa.',
                        'fun_fact' => 'Ghana was formerly known as the Gold Coast.',
                        'points' => 10,
                        'order' => 1,
                    ],
                    [
                        'question' => 'What is the most populous country in West Africa?',
                        'options' => json_encode(['Ghana', 'Nigeria', 'Senegal', 'Ivory Coast']),
                        'correct_answer' => 'Nigeria',
                        'explanation' => 'Nigeria is the most populous country in Africa with over 200 million people.',
                        'fun_fact' => 'Nigeria has over 250 ethnic groups!',
                        'points' => 10,
                        'order' => 2,
                    ],
                    [
                        'question' => 'Which West African country is known as the "Giant of West Africa"?',
                        'options' => json_encode(['Ghana', 'Nigeria', 'Senegal', 'Mali']),
                        'correct_answer' => 'Nigeria',
                        'explanation' => 'Nigeria is often called the "Giant of Africa" due to its large population and economy.',
                        'fun_fact' => 'Nigeria has the largest economy in Africa.',
                        'points' => 10,
                        'order' => 3,
                    ],
                ];

                foreach ($questions as $q) {
                    $q['puzzle_id'] = $puzzle->id;
                    PuzzleQuestion::updateOrCreate(
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => $q['question']
                        ],
                        $q
                    );
                }
            }

            if ($puzzle->slug == 'african-flags-quiz') {
                $questions = [
                    [
                        'question' => 'Which country has a flag with green, yellow, and red horizontal stripes and a black star?',
                        'options' => json_encode(['Ghana', 'Ethiopia', 'Cameroon', 'Senegal']),
                        'correct_answer' => 'Ghana',
                        'explanation' => 'Ghana\'s flag features red, gold, and green horizontal stripes with a black star in the center.',
                        'fun_fact' => 'The black star is a symbol of African emancipation.',
                        'points' => 10,
                        'order' => 1,
                    ],
                    [
                        'question' => 'Which country\'s flag is green with a yellow star in the center?',
                        'options' => json_encode(['Mauritania', 'Senegal', 'Mali', 'Cameroon']),
                        'correct_answer' => 'Mauritania',
                        'explanation' => 'Mauritania\'s flag is green with a gold star and crescent.',
                        'fun_fact' => 'The green represents Islam, and the crescent and star are also Islamic symbols.',
                        'points' => 10,
                        'order' => 2,
                    ],
                ];

                foreach ($questions as $q) {
                    $q['puzzle_id'] = $puzzle->id;
                    PuzzleQuestion::updateOrCreate(
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => $q['question']
                        ],
                        $q
                    );
                }
            }
        }

        $this->command->info('Puzzles seeded successfully!');
    }
}