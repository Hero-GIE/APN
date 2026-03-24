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
            ['name' => 'Countries', 'slug' => 'countries', 'description' => 'Test your knowledge of African countries', 'icon' => 'fas fa-map', 'color' => '#3b82f6', 'display_order' => 1],
            ['name' => 'Capitals', 'slug' => 'capitals', 'description' => 'African capital cities quiz', 'icon' => 'fas fa-city', 'color' => '#10b981', 'display_order' => 2],
            ['name' => 'Flags', 'slug' => 'flags', 'description' => 'Match flags to countries', 'icon' => 'fas fa-flag', 'color' => '#f59e0b', 'display_order' => 3],
            ['name' => 'Heritage', 'slug' => 'heritage', 'description' => 'African culture, history and heritage', 'icon' => 'fas fa-landmark', 'color' => '#8b5cf6', 'display_order' => 4],
        ];

        foreach ($categories as $cat) {
            PuzzleCategory::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // Create achievements
        $achievements = [
            ['name' => 'First Steps', 'slug' => 'first-steps', 'description' => 'Complete your first puzzle', 'icon' => 'fas fa-shoe-prints', 'criteria' => json_encode(['type' => 'total_score', 'threshold' => 1]), 'points' => 10, 'rarity' => 'common'],
            ['name' => 'Perfect Score', 'slug' => 'perfect-score', 'description' => 'Get a perfect score on any puzzle', 'icon' => 'fas fa-star', 'criteria' => json_encode(['type' => 'perfect_score']), 'points' => 50, 'rarity' => 'rare'],
            ['name' => 'Country Expert', 'slug' => 'country-expert', 'description' => 'Answer 20 country questions correctly', 'icon' => 'fas fa-globe-africa', 'criteria' => json_encode(['type' => 'country_expert', 'count' => 20]), 'points' => 100, 'rarity' => 'epic'],
            ['name' => 'Capital Expert', 'slug' => 'capital-expert', 'description' => 'Answer 20 capital questions correctly', 'icon' => 'fas fa-city', 'criteria' => json_encode(['type' => 'capital_expert', 'count' => 20]), 'points' => 100, 'rarity' => 'epic'],
            ['name' => 'Flag Master', 'slug' => 'flag-master', 'description' => 'Identify 20 African flags correctly', 'icon' => 'fas fa-flag-checkered', 'criteria' => json_encode(['type' => 'flag_master', 'count' => 20]), 'points' => 100, 'rarity' => 'epic'],
            ['name' => 'African Scholar', 'slug' => 'african-scholar', 'description' => 'Complete all three major quizzes with 80%+ score', 'icon' => 'fas fa-graduation-cap', 'criteria' => json_encode(['type' => 'mastery', 'count' => 3]), 'points' => 500, 'rarity' => 'legendary'],
        ];

        foreach ($achievements as $ach) {
            PuzzleAchievement::updateOrCreate(['slug' => $ach['slug']], $ach);
        }

        // Create puzzles
        $puzzles = [
            [
                'title' => 'African Countries Quiz',
                'slug' => 'african-countries-quiz',
                'short_description' => 'Test your knowledge about African countries - 20 questions',
                'description' => 'How well do you know the countries of Africa? Answer 20 questions about African nations, their history, and culture to become a Country Expert!',
                'type' => 'quiz',
                'difficulty' => 'intermediate',
                'content' => json_encode(['format' => 'multiple_choice', 'levels' => 4, 'questions_per_level' => 5]),
                'settings' => json_encode(['time_limit' => 600, 'attempts' => 3, 'levels' => 4]),
                'base_points' => 200,
                'bonus_points' => 50,
                'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747193/a89b2db3-c78d-423e-b002-70bac096fc97_hkoukl.png',
                'thumbnail' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747193/a89b2db3-c78d-423e-b002-70bac096fc97_hkoukl.png',
                'time_limit' => 600,
                'attempts_allowed' => 3,
                'hints_allowed' => 5,
                'is_active' => true,
                'is_featured' => true,
                'is_timed' => true,
                'category_id' => 1,
            ],
            [
                'title' => 'African Capitals Challenge',
                'slug' => 'african-capitals-challenge',
                'short_description' => 'Test your knowledge of African capital cities - 20 questions',
                'description' => 'How well do you know the capitals of Africa? Answer 20 questions about African capital cities to become a Capital Expert!',
                'type' => 'quiz',
                'difficulty' => 'intermediate',
                'content' => json_encode(['format' => 'multiple_choice', 'levels' => 4, 'questions_per_level' => 5]),
                'settings' => json_encode(['time_limit' => 600, 'attempts' => 3, 'levels' => 4]),
                'base_points' => 200,
                'bonus_points' => 50,
                'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747723/West_African_puzzle_game_promotion_zrgfhv.png',
                'thumbnail' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747723/West_African_puzzle_game_promotion_zrgfhv.png',
                'time_limit' => 600,
                'attempts_allowed' => 3,
                'hints_allowed' => 5,
                'is_active' => true,
                'is_featured' => true,
                'is_timed' => true,
                'category_id' => 2,
            ],
            [
                'title' => 'African Flags Quiz',
                'slug' => 'african-flags-quiz',
                'short_description' => 'Match flags to their countries - 20 questions',
                'description' => 'Can you identify African flags? Answer 20 flag identification questions to become a Flag Master!',
                'type' => 'flag_match',
                'difficulty' => 'expert',
                'content' => json_encode(['format' => 'image_match', 'levels' => 4, 'questions_per_level' => 5]),
                'settings' => json_encode(['time_limit' => 900, 'attempts' => 3, 'levels' => 4]),
                'base_points' => 200,
                'bonus_points' => 50,
                'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747434/African_flags_puzzle_adventure_scene_kthqw6.png',
                'thumbnail' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747434/African_flags_puzzle_adventure_scene_kthqw6.png',
                'time_limit' => 900,
                'attempts_allowed' => 3,
                'hints_allowed' => 5,
                'is_active' => true,
                'is_featured' => true,
                'is_timed' => true,
                'category_id' => 3,
            ],
        ];

        // 20 African Countries Questions (Interesting facts)
        $countryQuestions = [
            ['country' => 'Ghana', 'question' => 'Which African country was formerly known as the Gold Coast?', 'fun_fact' => 'Ghana was the first sub-Saharan African country to gain independence in 1957.'],
            ['country' => 'Nigeria', 'question' => 'Which African country is the most populous, with over 200 million people?', 'fun_fact' => 'Nigeria has over 250 ethnic groups and is the largest economy in Africa.'],
            ['country' => 'Kenya', 'question' => 'Which country is home to the Great Wildebeest Migration and Maasai Mara?', 'fun_fact' => 'Kenya is known as the "Safari Capital of the World".'],
            ['country' => 'South Africa', 'question' => 'Which country has three capital cities: Pretoria, Cape Town, and Bloemfontein?', 'fun_fact' => 'South Africa is the only country with three capital cities and 11 official languages.'],
            ['country' => 'Egypt', 'question' => 'Which African country is home to the Great Pyramids of Giza?', 'fun_fact' => 'Egypt is often called the "Gift of the Nile".'],
            ['country' => 'Ethiopia', 'question' => 'Which African country is the only one that was never colonized?', 'fun_fact' => 'Ethiopia is the oldest independent country in Africa.'],
            ['country' => 'Morocco', 'question' => 'Which African country is famous for its blue city, Chefchaouen?', 'fun_fact' => 'Morocco is the only African country with coastlines on both the Atlantic and Mediterranean.'],
            ['country' => 'Tanzania', 'question' => 'Which country is home to Mount Kilimanjaro, the highest peak in Africa?', 'fun_fact' => 'Mount Kilimanjaro is the tallest free-standing mountain in the world.'],
            ['country' => 'Senegal', 'question' => 'Which country is known for its wrestling culture and the famous Dakar Rally?', 'fun_fact' => 'Senegal was the first African country to host the Olympics-style Youth Games.'],
            ['country' => 'Rwanda', 'question' => 'Which country is known as the "Land of a Thousand Hills"?', 'fun_fact' => 'Rwanda is home to over half of the world\'s remaining mountain gorillas.'],
            ['country' => 'Botswana', 'question' => 'Which country has the world\'s largest elephant population?', 'fun_fact' => 'Botswana is one of the most sparsely populated countries in the world.'],
            ['country' => 'Madagascar', 'question' => 'Which island country is home to lemurs and over 90% of its wildlife found nowhere else?', 'fun_fact' => 'Madagascar split from India about 88 million years ago.'],
            ['country' => 'Zimbabwe', 'question' => 'Which country is home to Victoria Falls, one of the Seven Natural Wonders?', 'fun_fact' => 'Victoria Falls is locally known as "Mosi-oa-Tunya" meaning "The Smoke that Thunders".'],
            ['country' => 'Mali', 'question' => 'Which country was home to the ancient city of Timbuktu, a center of Islamic learning?', 'fun_fact' => 'Mali was once one of the richest empires in the world under Mansa Musa.'],
            ['country' => 'Namibia', 'question' => 'Which country is home to the world\'s oldest desert, the Namib Desert?', 'fun_fact' => 'The Namib Desert is estimated to be 55-80 million years old.'],
            ['country' => 'Uganda', 'question' => 'Which country is home to over half of the world\'s mountain gorilla population?', 'fun_fact' => 'Uganda is often called the "Pearl of Africa".'],
            ['country' => 'Zambia', 'question' => 'Which country shares Victoria Falls with Zimbabwe?', 'fun_fact' => 'Zambia\'s name comes from the Zambezi River.'],
            ['country' => 'Cameroon', 'question' => 'Which country is often called "Africa in miniature" for its geographical diversity?', 'fun_fact' => 'Cameroon has beaches, deserts, mountains, rainforests, and savannahs.'],
            ['country' => 'Ivory Coast', 'question' => 'Which country is the world\'s largest producer of cocoa beans?', 'fun_fact' => 'Ivory Coast produces about 40% of the world\'s cocoa.'],
            ['country' => 'Mauritius', 'question' => 'Which island nation was the only known home of the now-extinct dodo bird?', 'fun_fact' => 'Mauritius has the highest GDP per capita in Africa.'],
        ];

        // 20 African Capitals Questions
        $capitalQuestions = [
            ['country' => 'Ghana', 'capital' => 'Accra', 'fun_fact' => 'Accra means "ants" in the local Ga language.'],
            ['country' => 'Nigeria', 'capital' => 'Abuja', 'fun_fact' => 'Abuja was purpose-built as the capital city in the 1980s.'],
            ['country' => 'Kenya', 'capital' => 'Nairobi', 'fun_fact' => 'Nairobi is known as the "Green City in the Sun".'],
            ['country' => 'South Africa', 'capital' => 'Pretoria', 'fun_fact' => 'South Africa has three capitals: Pretoria (executive), Cape Town (legislative), Bloemfontein (judicial).'],
            ['country' => 'Egypt', 'capital' => 'Cairo', 'fun_fact' => 'Cairo is the largest city in Africa and the Middle East.'],
            ['country' => 'Morocco', 'capital' => 'Rabat', 'fun_fact' => 'Many people think Casablanca is the capital because of the famous movie!'],
            ['country' => 'Tanzania', 'capital' => 'Dodoma', 'fun_fact' => 'Dodoma replaced Dar es Salaam as the capital in 1974.'],
            ['country' => 'Ethiopia', 'capital' => 'Addis Ababa', 'fun_fact' => 'Addis Ababa means "New Flower" in Amharic.'],
            ['country' => 'Senegal', 'capital' => 'Dakar', 'fun_fact' => 'Dakar is the westernmost city on the African mainland.'],
            ['country' => 'Rwanda', 'capital' => 'Kigali', 'fun_fact' => 'Kigali is one of the cleanest cities in Africa.'],
            ['country' => 'Uganda', 'capital' => 'Kampala', 'fun_fact' => 'Kampala is built on seven hills, like Rome.'],
            ['country' => 'Zambia', 'capital' => 'Lusaka', 'fun_fact' => 'Lusaka is named after a local chief.'],
            ['country' => 'Zimbabwe', 'capital' => 'Harare', 'fun_fact' => 'Harare was originally named Salisbury after a British prime minister.'],
            ['country' => 'Botswana', 'capital' => 'Gaborone', 'fun_fact' => 'Gaborone is named after Chief Gaborone.'],
            ['country' => 'Namibia', 'capital' => 'Windhoek', 'fun_fact' => 'Windhoek means "windy corner" in Afrikaans.'],
            ['country' => 'Mali', 'capital' => 'Bamako', 'fun_fact' => 'Bamako is located on the Niger River.'],
            ['country' => 'Burkina Faso', 'capital' => 'Ouagadougou', 'fun_fact' => 'Ouagadougou has one of the longest city names in the world.'],
            ['country' => 'Niger', 'capital' => 'Niamey', 'fun_fact' => 'Niamey is located on the Niger River.'],
            ['country' => 'Chad', 'capital' => "N'Djamena", 'fun_fact' => "N'Djamena is located at the confluence of the Chari and Logone rivers."],
            ['country' => 'Sudan', 'capital' => 'Khartoum', 'fun_fact' => 'Khartoum is located at the confluence of the Blue and White Nile rivers.'],
        ];

        // 20 African Flags Questions
        $flagQuestions = [
            ['country' => 'Ghana', 'flag' => 'https://flagpedia.net/data/flags/h80/gh.png', 'fun_fact' => 'The black star represents African freedom and unity.'],
            ['country' => 'Nigeria', 'flag' => 'https://flagpedia.net/data/flags/h80/ng.png', 'fun_fact' => 'The green represents forests, white represents peace.'],
            ['country' => 'Kenya', 'flag' => 'https://flagpedia.net/data/flags/h80/ke.png', 'fun_fact' => 'The Maasai shield and spears symbolize defense of freedom.'],
            ['country' => 'South Africa', 'flag' => 'https://flagpedia.net/data/flags/h80/za.png', 'fun_fact' => 'The Y-shape symbolizes the convergence of diverse elements.'],
            ['country' => 'Egypt', 'flag' => 'https://flagpedia.net/data/flags/h80/eg.png', 'fun_fact' => 'The Eagle of Saladin represents Arab nationalism.'],
            ['country' => 'Morocco', 'flag' => 'https://flagpedia.net/data/flags/h80/ma.png', 'fun_fact' => 'The green star is known as the Seal of Solomon.'],
            ['country' => 'Ethiopia', 'flag' => 'https://flagpedia.net/data/flags/h80/et.png', 'fun_fact' => 'These colors inspired many other African flags.'],
            ['country' => 'Tanzania', 'flag' => 'https://flagpedia.net/data/flags/h80/tz.png', 'fun_fact' => 'Green represents agriculture, blue represents water.'],
            ['country' => 'Uganda', 'flag' => 'https://flagpedia.net/data/flags/h80/ug.png', 'fun_fact' => 'The Grey Crowned Crane is the national bird.'],
            ['country' => 'Senegal', 'flag' => 'https://flagpedia.net/data/flags/h80/sn.png', 'fun_fact' => 'The green star represents the country\'s commitment to African unity.'],
            ['country' => 'Rwanda', 'flag' => 'https://flagpedia.net/data/flags/h80/rw.png', 'fun_fact' => 'The sun represents unity and transparency.'],
            ['country' => 'Mozambique', 'flag' => 'https://flagpedia.net/data/flags/h80/mz.png', 'fun_fact' => 'It is the only flag in the world featuring an AK-47.'],
            ['country' => 'Zambia', 'flag' => 'https://flagpedia.net/data/flags/h80/zm.png', 'fun_fact' => 'The eagle represents freedom and the ability to rise above challenges.'],
            ['country' => 'Zimbabwe', 'flag' => 'https://flagpedia.net/data/flags/h80/zw.png', 'fun_fact' => 'The bird represents the Great Zimbabwe bird.'],
            ['country' => 'Botswana', 'flag' => 'https://flagpedia.net/data/flags/h80/bw.png', 'fun_fact' => 'The stripes represent the zebra and racial harmony.'],
            ['country' => 'Namibia', 'flag' => 'https://flagpedia.net/data/flags/h80/na.png', 'fun_fact' => 'The sun represents life and energy.'],
            ['country' => 'Mali', 'flag' => 'https://flagpedia.net/data/flags/h80/ml.png', 'fun_fact' => 'The colors are pan-African colors.'],
            ['country' => 'Burkina Faso', 'flag' => 'https://flagpedia.net/data/flags/h80/bf.png', 'fun_fact' => 'The star represents the revolutionary guiding light.'],
            ['country' => 'Benin', 'flag' => 'https://flagpedia.net/data/flags/h80/bj.png', 'fun_fact' => 'The colors represent hope, courage, and wealth.'],
            ['country' => 'Togo', 'flag' => 'https://flagpedia.net/data/flags/h80/tg.png', 'fun_fact' => 'The stripes represent the five regions of Togo.'],
        ];

        foreach ($puzzles as $puzzleData) {
            $puzzle = Puzzle::updateOrCreate(['slug' => $puzzleData['slug']], $puzzleData);

            // African Countries Quiz - 20 questions
            if ($puzzle->slug == 'african-countries-quiz') {
                $order = 1;
                foreach ($countryQuestions as $q) {
                    $wrongOptions = [];
                    $allCountries = array_column($countryQuestions, 'country');
                    while (count($wrongOptions) < 3) {
                        $randomCountry = $allCountries[array_rand($allCountries)];
                        if ($randomCountry !== $q['country'] && !in_array($randomCountry, $wrongOptions)) {
                            $wrongOptions[] = $randomCountry;
                        }
                    }
                    
                    $options = array_merge([$q['country']], $wrongOptions);
                    shuffle($options);
                    
                    PuzzleQuestion::updateOrCreate(
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => $q['question'],
                            'order' => $order
                        ],
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => $q['question'],
                            'options' => json_encode($options),
                            'correct_answer' => $q['country'],
                            'explanation' => "{$q['country']} - {$q['fun_fact']}",
                            'fun_fact' => $q['fun_fact'],
                            'points' => 10,
                            'order' => $order,
                            'is_active' => true,
                        ]
                    );
                    $order++;
                }
            }

            // African Capitals Quiz - 20 questions
            if ($puzzle->slug == 'african-capitals-challenge') {
                $order = 1;
                foreach ($capitalQuestions as $cap) {
                    $wrongOptions = [];
                    $allCapitals = array_column($capitalQuestions, 'capital');
                    while (count($wrongOptions) < 3) {
                        $randomCapital = $allCapitals[array_rand($allCapitals)];
                        if ($randomCapital !== $cap['capital'] && !in_array($randomCapital, $wrongOptions)) {
                            $wrongOptions[] = $randomCapital;
                        }
                    }
                    
                    $options = array_merge([$cap['capital']], $wrongOptions);
                    shuffle($options);
                    
                    PuzzleQuestion::updateOrCreate(
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => "What is the capital of {$cap['country']}?",
                            'order' => $order
                        ],
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => "What is the capital of {$cap['country']}?",
                            'options' => json_encode($options),
                            'correct_answer' => $cap['capital'],
                            'explanation' => "{$cap['capital']} is the capital of {$cap['country']}. {$cap['fun_fact']}",
                            'fun_fact' => $cap['fun_fact'],
                            'points' => 10,
                            'order' => $order,
                            'is_active' => true,
                        ]
                    );
                    $order++;
                }
            }

            // African Flags Quiz - 20 questions
            if ($puzzle->slug == 'african-flags-quiz') {
                $order = 1;
                foreach ($flagQuestions as $flag) {
                    $wrongOptions = [];
                    $allCountries = array_column($flagQuestions, 'country');
                    while (count($wrongOptions) < 3) {
                        $randomCountry = $allCountries[array_rand($allCountries)];
                        if ($randomCountry !== $flag['country'] && !in_array($randomCountry, $wrongOptions)) {
                            $wrongOptions[] = $randomCountry;
                        }
                    }
                    
                    $options = array_merge([$flag['country']], $wrongOptions);
                    shuffle($options);
                    
                    PuzzleQuestion::updateOrCreate(
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => $flag['flag'],
                            'order' => $order
                        ],
                        [
                            'puzzle_id' => $puzzle->id,
                            'question' => $flag['flag'],
                            'options' => json_encode($options),
                            'correct_answer' => $flag['country'],
                            'explanation' => "This is the flag of {$flag['country']}. {$flag['fun_fact']}",
                            'fun_fact' => $flag['fun_fact'],
                            'points' => 10,
                            'order' => $order,
                            'image' => $flag['flag'],
                            'is_active' => true,
                        ]
                    );
                    $order++;
                }
            }
        }

        $this->command->info('Puzzles seeded successfully!');
        $this->command->info('African Countries Quiz created with 20 interesting questions!');
        $this->command->info('African Capitals Quiz created with 20 capital questions!');
        $this->command->info('African Flags Quiz created with 20 flag questions!');
    }
}