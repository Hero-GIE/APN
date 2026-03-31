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
                'base_points' => 200,
                'bonus_points' => 20,
                'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747193/a89b2db3-c78d-423e-b002-70bac096fc97_hkoukl.png',
                'thumbnail' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747193/a89b2db3-c78d-423e-b002-70bac096fc97_hkoukl.png',
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
                'base_points' => 200,
                'bonus_points' => 20,
                'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747723/West_African_puzzle_game_promotion_zrgfhv.png',
                'thumbnail' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747723/West_African_puzzle_game_promotion_zrgfhv.png',
                'time_limit' => null,
                'attempts_allowed' => 5,
                'hints_allowed' => 3,
                'is_active' => true,
                'is_featured' => false,
                'is_timed' => false,
                'category_id' => 1, // Countries
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
                'base_points' => 200,
                'bonus_points' => 30,
                'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747434/African_flags_puzzle_adventure_scene_kthqw6.png',
                'thumbnail' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747434/African_flags_puzzle_adventure_scene_kthqw6.png',
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

            // Add questions for African Capitals Quiz
            if ($puzzle->slug == 'african-capitals-challenge') {
                $questions = [
                    ['question' => 'What is the capital of Ghana?', 'options' => json_encode(['Accra', 'Kumasi', 'Tamale', 'Cape Coast']), 'correct_answer' => 'Accra', 'explanation' => 'Accra is the capital and largest city of Ghana, located on the Atlantic coast.', 'fun_fact' => 'Accra means "ants" in the local Ga language!', 'points' => 10, 'order' => 1],
                    ['question' => 'What is the capital of Nigeria?', 'options' => json_encode(['Lagos', 'Abuja', 'Kano', 'Ibadan']), 'correct_answer' => 'Abuja', 'explanation' => 'Abuja became the capital of Nigeria in 1991, replacing Lagos.', 'fun_fact' => 'Abuja was purpose-built as the capital city in the 1980s.', 'points' => 10, 'order' => 2],
                    ['question' => 'What is the capital of Kenya?', 'options' => json_encode(['Mombasa', 'Nairobi', 'Kisumu', 'Nakuru']), 'correct_answer' => 'Nairobi', 'explanation' => 'Nairobi is the capital and largest city of Kenya.', 'fun_fact' => 'Nairobi is known as the "Green City in the Sun".', 'points' => 10, 'order' => 3],
                    ['question' => 'What is the capital of South Africa?', 'options' => json_encode(['Cape Town', 'Pretoria', 'Bloemfontein', 'All of the above']), 'correct_answer' => 'All of the above', 'explanation' => 'South Africa has three capitals: Pretoria (executive), Cape Town (legislative), and Bloemfontein (judicial).', 'fun_fact' => 'South Africa is the only country with three capital cities!', 'points' => 10, 'order' => 4],
                    ['question' => 'What is the capital of Egypt?', 'options' => json_encode(['Alexandria', 'Cairo', 'Giza', 'Luxor']), 'correct_answer' => 'Cairo', 'explanation' => 'Cairo is the capital and largest city of Egypt.', 'fun_fact' => 'Cairo means "The Vanquisher" or "The Triumphant" in Arabic.', 'points' => 10, 'order' => 5],
                    ['question' => 'What is the capital of Morocco?', 'options' => json_encode(['Casablanca', 'Rabat', 'Marrakesh', 'Fes']), 'correct_answer' => 'Rabat', 'explanation' => 'Rabat is the capital of Morocco, located on the Atlantic coast.', 'fun_fact' => 'Many people think Casablanca is the capital because of the famous movie!', 'points' => 10, 'order' => 6],
                    ['question' => 'What is the capital of Senegal?', 'options' => json_encode(['Dakar', 'Thies', 'Saint-Louis', 'Ziguinchor']), 'correct_answer' => 'Dakar', 'explanation' => 'Dakar is the capital and largest city of Senegal.', 'fun_fact' => 'Dakar is the westernmost city on the African mainland.', 'points' => 10, 'order' => 7],
                    ['question' => 'What is the capital of Ethiopia?', 'options' => json_encode(['Addis Ababa', 'Dire Dawa', 'Gondar', 'Lalibela']), 'correct_answer' => 'Addis Ababa', 'explanation' => 'Addis Ababa is the capital and largest city of Ethiopia.', 'fun_fact' => 'Addis Ababa means "new flower" in Amharic.', 'points' => 10, 'order' => 8],
                    ['question' => 'What is the capital of Tanzania?', 'options' => json_encode(['Dar es Salaam', 'Dodoma', 'Arusha', 'Zanzibar City']), 'correct_answer' => 'Dodoma', 'explanation' => 'Dodoma is the official capital of Tanzania, though Dar es Salaam remains the commercial capital.', 'fun_fact' => 'The government moved to Dodoma in 1974.', 'points' => 10, 'order' => 9],
                    ['question' => 'What is the capital of Uganda?', 'options' => json_encode(['Kampala', 'Entebbe', 'Jinja', 'Gulu']), 'correct_answer' => 'Kampala', 'explanation' => 'Kampala is the capital and largest city of Uganda.', 'fun_fact' => 'Kampala was originally built on seven hills.', 'points' => 10, 'order' => 10],
                    ['question' => 'What is the capital of Rwanda?', 'options' => json_encode(['Kigali', 'Butare', 'Gisenyi', 'Ruhengeri']), 'correct_answer' => 'Kigali', 'explanation' => 'Kigali is the capital and largest city of Rwanda.', 'fun_fact' => 'Kigali is one of the cleanest cities in Africa.', 'points' => 10, 'order' => 11],
                    ['question' => 'What is the capital of Zimbabwe?', 'options' => json_encode(['Harare', 'Bulawayo', 'Mutare', 'Gweru']), 'correct_answer' => 'Harare', 'explanation' => 'Harare is the capital and largest city of Zimbabwe.', 'fun_fact' => 'Harare was formerly known as Salisbury.', 'points' => 10, 'order' => 12],
                    ['question' => 'What is the capital of Zambia?', 'options' => json_encode(['Lusaka', 'Ndola', 'Kitwe', 'Livingstone']), 'correct_answer' => 'Lusaka', 'explanation' => 'Lusaka is the capital and largest city of Zambia.', 'fun_fact' => 'Lusaka is located on the Central African Plateau.', 'points' => 10, 'order' => 13],
                    ['question' => 'What is the capital of Botswana?', 'options' => json_encode(['Gaborone', 'Francistown', 'Maun', 'Kasane']), 'correct_answer' => 'Gaborone', 'explanation' => 'Gaborone is the capital and largest city of Botswana.', 'fun_fact' => 'Gaborone means "it does not fit poorly" in Tswana.', 'points' => 10, 'order' => 14],
                    ['question' => 'What is the capital of Namibia?', 'options' => json_encode(['Windhoek', 'Walvis Bay', 'Swakopmund', 'Oshakati']), 'correct_answer' => 'Windhoek', 'explanation' => 'Windhoek is the capital and largest city of Namibia.', 'fun_fact' => 'Windhoek is known for its German colonial architecture.', 'points' => 10, 'order' => 15],
                    ['question' => 'What is the capital of Mozambique?', 'options' => json_encode(['Maputo', 'Beira', 'Nampula', 'Matola']), 'correct_answer' => 'Maputo', 'explanation' => 'Maputo is the capital and largest city of Mozambique.', 'fun_fact' => 'Maputo was formerly known as Lourenço Marques.', 'points' => 10, 'order' => 16],
                    ['question' => 'What is the capital of Angola?', 'options' => json_encode(['Luanda', 'Huambo', 'Lubango', 'Benguela']), 'correct_answer' => 'Luanda', 'explanation' => 'Luanda is the capital and largest city of Angola.', 'fun_fact' => 'Luanda is one of the most expensive cities in the world.', 'points' => 10, 'order' => 17],
                    ['question' => 'What is the capital of Tunisia?', 'options' => json_encode(['Tunis', 'Sfax', 'Sousse', 'Kairouan']), 'correct_answer' => 'Tunis', 'explanation' => 'Tunis is the capital and largest city of Tunisia.', 'fun_fact' => 'Tunis is located on the Mediterranean coast.', 'points' => 10, 'order' => 18],
                    ['question' => 'What is the capital of Algeria?', 'options' => json_encode(['Algiers', 'Oran', 'Constantine', 'Annaba']), 'correct_answer' => 'Algiers', 'explanation' => 'Algiers is the capital and largest city of Algeria.', 'fun_fact' => 'Algiers is known as "Alger la Blanche" (Algiers the White).', 'points' => 10, 'order' => 19],
                    ['question' => 'What is the capital of Sudan?', 'options' => json_encode(['Khartoum', 'Omdurman', 'Port Sudan', 'Kassala']), 'correct_answer' => 'Khartoum', 'explanation' => 'Khartoum is the capital of Sudan, located at the confluence of the Blue and White Nile.', 'fun_fact' => 'Khartoum means "elephant trunk" in Arabic.', 'points' => 10, 'order' => 20],
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

            // Add questions for West African Countries
            if ($puzzle->slug == 'west-african-countries') {
                $questions = [
                    ['question' => 'Which of these countries is in West Africa?', 'options' => json_encode(['Ethiopia', 'Ghana', 'Kenya', 'Tanzania']), 'correct_answer' => 'Ghana', 'explanation' => 'Ghana is located in West Africa, while the others are in East Africa.', 'fun_fact' => 'Ghana was formerly known as the Gold Coast.', 'points' => 10, 'order' => 1],
                    ['question' => 'What is the most populous country in West Africa?', 'options' => json_encode(['Ghana', 'Nigeria', 'Senegal', 'Ivory Coast']), 'correct_answer' => 'Nigeria', 'explanation' => 'Nigeria is the most populous country in Africa with over 200 million people.', 'fun_fact' => 'Nigeria has over 250 ethnic groups!', 'points' => 10, 'order' => 2],
                    ['question' => 'Which West African country is known as the "Giant of West Africa"?', 'options' => json_encode(['Ghana', 'Nigeria', 'Senegal', 'Mali']), 'correct_answer' => 'Nigeria', 'explanation' => 'Nigeria is often called the "Giant of Africa" due to its large population and economy.', 'fun_fact' => 'Nigeria has the largest economy in Africa.', 'points' => 10, 'order' => 3],
                    ['question' => 'Which country in West Africa is known for its jollof rice?', 'options' => json_encode(['Nigeria', 'Ghana', 'Both Nigeria and Ghana', 'Senegal']), 'correct_answer' => 'Both Nigeria and Ghana', 'explanation' => 'Both Nigeria and Ghana claim to have the best jollof rice, a popular West African dish.', 'fun_fact' => 'Jollof rice originated in Senegal.', 'points' => 10, 'order' => 4],
                    ['question' => 'Which West African country is famous for its ancient city of Timbuktu?', 'options' => json_encode(['Mali', 'Niger', 'Burkina Faso', 'Mauritania']), 'correct_answer' => 'Mali', 'explanation' => 'Timbuktu is an ancient city in Mali, once a center of Islamic learning.', 'fun_fact' => 'Timbuktu is a UNESCO World Heritage site.', 'points' => 10, 'order' => 5],
                    ['question' => 'Which country in West Africa was the first to gain independence?', 'options' => json_encode(['Nigeria', 'Ghana', 'Senegal', 'Liberia']), 'correct_answer' => 'Ghana', 'explanation' => 'Ghana gained independence in 1957, becoming the first sub-Saharan African country to do so.', 'fun_fact' => 'Ghana\'s first president was Kwame Nkrumah.', 'points' => 10, 'order' => 6],
                    ['question' => 'Which West African country is known for its beaches and as a tourist destination?', 'options' => json_encode(['Niger', 'Burkina Faso', 'Gambia', 'Mali']), 'correct_answer' => 'Gambia', 'explanation' => 'Gambia is known for its beautiful beaches and is a popular tourist destination.', 'fun_fact' => 'Gambia is the smallest country in mainland Africa.', 'points' => 10, 'order' => 7],
                    ['question' => 'Which West African country is the largest producer of cocoa?', 'options' => json_encode(['Ghana', 'Nigeria', 'Ivory Coast', 'Cameroon']), 'correct_answer' => 'Ivory Coast', 'explanation' => 'Ivory Coast is the world\'s largest producer of cocoa.', 'fun_fact' => 'Ivory Coast produces about 40% of the world\'s cocoa.', 'points' => 10, 'order' => 8],
                    ['question' => 'Which country in West Africa is known for its "Great Mosque of Djenné"?', 'options' => json_encode(['Mali', 'Senegal', 'Niger', 'Burkina Faso']), 'correct_answer' => 'Mali', 'explanation' => 'The Great Mosque of Djenné is the largest mud-brick building in the world.', 'fun_fact' => 'The mosque was first built in the 13th century.', 'points' => 10, 'order' => 9],
                    ['question' => 'Which West African country has English as its official language?', 'options' => json_encode(['Senegal', 'Ivory Coast', 'Liberia', 'Guinea']), 'correct_answer' => 'Liberia', 'explanation' => 'Liberia is one of the English-speaking countries in West Africa.', 'fun_fact' => 'Liberia was founded by freed American slaves in 1822.', 'points' => 10, 'order' => 10],
                    ['question' => 'Which West African country is known for its voodoo religion?', 'options' => json_encode(['Ghana', 'Benin', 'Togo', 'Nigeria']), 'correct_answer' => 'Benin', 'explanation' => 'Benin is considered the birthplace of voodoo (vodun).', 'fun_fact' => 'Voodoo is an official religion in Benin.', 'points' => 10, 'order' => 11],
                    ['question' => 'Which country in West Africa is famous for its rich music scene and Afrobeat music?', 'options' => json_encode(['Nigeria', 'Ghana', 'Senegal', 'Mali']), 'correct_answer' => 'Nigeria', 'explanation' => 'Nigeria is famous for Afrobeat music pioneered by Fela Kuti.', 'fun_fact' => 'Afrobeat combines West African music with jazz and funk.', 'points' => 10, 'order' => 12],
                    ['question' => 'Which West African country is known for the Pink Lake (Lake Retba)?', 'options' => json_encode(['Mauritania', 'Senegal', 'Gambia', 'Guinea-Bissau']), 'correct_answer' => 'Senegal', 'explanation' => 'Lake Retba is known for its pink color caused by Dunaliella salina algae.', 'fun_fact' => 'The lake has a high salt concentration similar to the Dead Sea.', 'points' => 10, 'order' => 13],
                    ['question' => 'Which country in West Africa is home to the Yoruba people?', 'options' => json_encode(['Ghana', 'Nigeria', 'Benin', 'Both Nigeria and Benin']), 'correct_answer' => 'Both Nigeria and Benin', 'explanation' => 'The Yoruba people are primarily in Nigeria but also have significant populations in Benin.', 'fun_fact' => 'The Yoruba are one of the largest ethnic groups in Africa.', 'points' => 10, 'order' => 14],
                    ['question' => 'Which West African country is known for its cotton production?', 'options' => json_encode(['Burkina Faso', 'Mali', 'Chad', 'All of the above']), 'correct_answer' => 'All of the above', 'explanation' => 'Burkina Faso, Mali, and Chad are all major cotton producers in West Africa.', 'fun_fact' => 'Cotton is often called "white gold" in these countries.', 'points' => 10, 'order' => 15],
                    ['question' => 'Which country in West Africa is known as the "Pearl of West Africa"?', 'options' => json_encode(['Ghana', 'Nigeria', 'Senegal', 'Ivory Coast']), 'correct_answer' => 'Ghana', 'explanation' => 'Ghana is sometimes called the "Pearl of West Africa" for its stability and development.', 'fun_fact' => 'Ghana was the first African country to win the Africa Cup of Nations.', 'points' => 10, 'order' => 16],
                    ['question' => 'Which West African country has French as its official language?', 'options' => json_encode(['Nigeria', 'Ghana', 'Senegal', 'Liberia']), 'correct_answer' => 'Senegal', 'explanation' => 'Senegal, like many West African countries, has French as its official language.', 'fun_fact' => 'Senegal was formerly a French colony.', 'points' => 10, 'order' => 17],
                    ['question' => 'Which country in West Africa is known for its diamond production?', 'options' => json_encode(['Sierra Leone', 'Liberia', 'Guinea', 'All of the above']), 'correct_answer' => 'All of the above', 'explanation' => 'Sierra Leone, Liberia, and Guinea are all known for diamond mining.', 'fun_fact' => 'Sierra Leone\'s diamonds are known as "blood diamonds" due to conflict.', 'points' => 10, 'order' => 18],
                    ['question' => 'Which West African country is the largest in terms of land area?', 'options' => json_encode(['Nigeria', 'Mali', 'Niger', 'Mauritania']), 'correct_answer' => 'Niger', 'explanation' => 'Niger is the largest country in West Africa by land area.', 'fun_fact' => 'Most of Niger is covered by the Sahara Desert.', 'points' => 10, 'order' => 19],
                    ['question' => 'Which West African country is known for the Djenne-Djenno archaeological site?', 'options' => json_encode(['Mali', 'Senegal', 'Mauritania', 'Burkina Faso']), 'correct_answer' => 'Mali', 'explanation' => 'Djenne-Djenno is one of the oldest known cities in sub-Saharan Africa.', 'fun_fact' => 'The site dates back to 250 BC.', 'points' => 10, 'order' => 20],
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
        ['question' => 'https://flagpedia.net/data/flags/w320/gh.png', 'options' => json_encode(['Ghana', 'Cameroon', 'Senegal', 'Mali']), 'correct_answer' => 'Ghana', 'explanation' => 'Ghana\'s flag features red, gold, and green horizontal stripes with a black star.', 'fun_fact' => 'The black star represents African freedom and emancipation.', 'points' => 10, 'order' => 1],
        ['question' => 'https://flagpedia.net/data/flags/w320/mr.png', 'options' => json_encode(['Mauritania', 'Pakistan', 'Algeria', 'Comoros']), 'correct_answer' => 'Mauritania', 'explanation' => 'Mauritania\'s flag is green with a gold crescent and star.', 'fun_fact' => 'The green represents Islam, the dominant religion in Mauritania.', 'points' => 10, 'order' => 2],
        ['question' => 'https://flagpedia.net/data/flags/w320/ng.png', 'options' => json_encode(['Nigeria', 'Niger', 'Cameroon', 'Benin']), 'correct_answer' => 'Nigeria', 'explanation' => 'Nigeria\'s flag is green and white vertical stripes.', 'fun_fact' => 'The green represents agriculture, and white represents peace.', 'points' => 10, 'order' => 3],
        ['question' => 'https://flagpedia.net/data/flags/w320/za.png', 'options' => json_encode(['South Africa', 'Zimbabwe', 'Zambia', 'Botswana']), 'correct_answer' => 'South Africa', 'explanation' => 'South Africa\'s flag has six colors and a unique Y-shaped design.', 'fun_fact' => 'It is one of the most colorful flags in the world.', 'points' => 10, 'order' => 4],
        ['question' => 'https://flagpedia.net/data/flags/w320/ke.png', 'options' => json_encode(['Kenya', 'Uganda', 'Tanzania', 'Rwanda']), 'correct_answer' => 'Kenya', 'explanation' => 'Kenya\'s flag has black, red, and green stripes with a Maasai shield and spears.', 'fun_fact' => 'The shield and spears represent the defense of freedom.', 'points' => 10, 'order' => 5],
        ['question' => 'https://flagpedia.net/data/flags/w320/et.png', 'options' => json_encode(['Ethiopia', 'Eritrea', 'Sudan', 'Somalia']), 'correct_answer' => 'Ethiopia', 'explanation' => 'Ethiopia\'s flag has green, yellow, and red stripes with a central emblem.', 'fun_fact' => 'Ethiopia\'s colors inspired many African flags.', 'points' => 10, 'order' => 6],
        ['question' => 'https://flagpedia.net/data/flags/w320/sn.png', 'options' => json_encode(['Senegal', 'Mali', 'Guinea', 'Cameroon']), 'correct_answer' => 'Senegal', 'explanation' => 'Senegal\'s flag has green, yellow, and red vertical stripes with a green star.', 'fun_fact' => 'The star represents unity and hope.', 'points' => 10, 'order' => 7],
        ['question' => 'https://flagpedia.net/data/flags/w320/ma.png', 'options' => json_encode(['Morocco', 'Algeria', 'Tunisia', 'Libya']), 'correct_answer' => 'Morocco', 'explanation' => 'Morocco\'s flag is red with a green pentagram.', 'fun_fact' => 'The pentagram is known as the Seal of Solomon.', 'points' => 10, 'order' => 8],
        ['question' => 'https://flagpedia.net/data/flags/w320/lr.png', 'options' => json_encode(['Liberia', 'USA', 'Sierra Leone', 'Guinea']), 'correct_answer' => 'Liberia', 'explanation' => 'Liberia\'s flag has red and white stripes with a blue square and white star.', 'fun_fact' => 'It resembles the US flag because Liberia was founded by freed American slaves.', 'points' => 10, 'order' => 9],
        ['question' => 'https://flagpedia.net/data/flags/w320/eg.png', 'options' => json_encode(['Egypt', 'Sudan', 'Libya', 'Algeria']), 'correct_answer' => 'Egypt', 'explanation' => 'Egypt\'s flag has red, white, and black horizontal stripes with the Eagle of Saladin.', 'fun_fact' => 'The eagle represents strength and sovereignty.', 'points' => 10, 'order' => 10],
        ['question' => 'https://flagpedia.net/data/flags/w320/so.png', 'options' => json_encode(['Somalia', 'Djibouti', 'Eritrea', 'Ethiopia']), 'correct_answer' => 'Somalia', 'explanation' => 'Somalia\'s flag is light blue with a white five-pointed star.', 'fun_fact' => 'The star represents the five Somali-inhabited regions.', 'points' => 10, 'order' => 11],
        ['question' => 'https://flagpedia.net/data/flags/w320/cm.png', 'options' => json_encode(['Cameroon', 'Chad', 'Central African Republic', 'Congo']), 'correct_answer' => 'Cameroon', 'explanation' => 'Cameroon\'s flag has green, red, and yellow vertical stripes with a yellow star.', 'fun_fact' => 'The star is sometimes called the "star of unity."', 'points' => 10, 'order' => 12],
        ['question' => 'https://flagpedia.net/data/flags/w320/ci.png', 'options' => json_encode(['Ivory Coast', 'Ireland', 'Italy', 'Niger']), 'correct_answer' => 'Ivory Coast', 'explanation' => 'Ivory Coast\'s flag has orange, white, and green vertical stripes.', 'fun_fact' => 'Orange represents the savanna, green the forests, and white peace.', 'points' => 10, 'order' => 13],
        ['question' => 'https://flagpedia.net/data/flags/w320/tz.png', 'options' => json_encode(['Tanzania', 'Uganda', 'Kenya', 'Malawi']), 'correct_answer' => 'Tanzania', 'explanation' => 'Tanzania\'s flag has green, yellow, black, and blue stripes with a diagonal design.', 'fun_fact' => 'The green represents land, blue the Indian Ocean, and black the people.', 'points' => 10, 'order' => 14],
        ['question' => 'https://flagpedia.net/data/flags/w320/ug.png', 'options' => json_encode(['Uganda', 'Rwanda', 'Burundi', 'Kenya']), 'correct_answer' => 'Uganda', 'explanation' => 'Uganda\'s flag has black, yellow, and red stripes with a Grey Crowned Crane.', 'fun_fact' => 'The crane represents Uganda\'s wildlife and elegance.', 'points' => 10, 'order' => 15],
        ['question' => 'https://flagpedia.net/data/flags/w320/dz.png', 'options' => json_encode(['Algeria', 'Tunisia', 'Morocco', 'Libya']), 'correct_answer' => 'Algeria', 'explanation' => 'Algeria\'s flag is green and white with a red crescent and star.', 'fun_fact' => 'Green represents Islam, white purity, and red freedom.', 'points' => 10, 'order' => 16],
        ['question' => 'https://flagpedia.net/data/flags/w320/mz.png', 'options' => json_encode(['Mozambique', 'Angola', 'Zimbabwe', 'Zambia']), 'correct_answer' => 'Mozambique', 'explanation' => 'Mozambique\'s flag features a book, hoe, and AK-47.', 'fun_fact' => 'It is the only flag in the world with an AK-47.', 'points' => 10, 'order' => 17],
        ['question' => 'https://flagpedia.net/data/flags/w320/bw.png', 'options' => json_encode(['Botswana', 'Namibia', 'Zambia', 'Zimbabwe']), 'correct_answer' => 'Botswana', 'explanation' => 'Botswana\'s flag has light blue, black, and white stripes.', 'fun_fact' => 'The blue represents water, and the black and white represent racial harmony.', 'points' => 10, 'order' => 18],
        ['question' => 'https://flagpedia.net/data/flags/w320/rw.png', 'options' => json_encode(['Rwanda', 'Burundi', 'Uganda', 'Tanzania']), 'correct_answer' => 'Rwanda', 'explanation' => 'Rwanda\'s flag has blue, yellow, and green stripes with a sun.', 'fun_fact' => 'The sun represents enlightenment and hope.', 'points' => 10, 'order' => 19],
        ['question' => 'https://flagpedia.net/data/flags/w320/zw.png', 'options' => json_encode(['Zimbabwe', 'Zambia', 'Botswana', 'Namibia']), 'correct_answer' => 'Zimbabwe', 'explanation' => 'Zimbabwe\'s flag has green, yellow, red, and black stripes with a Zimbabwe Bird.', 'fun_fact' => 'The Zimbabwe Bird is a national symbol found in ancient ruins.', 'points' => 10, 'order' => 20],
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

        $this->command->info('Puzzles seeded successfully with 20 questions each!');
    }
}