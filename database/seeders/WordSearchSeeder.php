<?php

namespace Database\Seeders;

use App\Models\WordSearchPuzzle;
use Illuminate\Database\Seeder;

class WordSearchSeeder extends Seeder
{
    public function run()
    {
        // African Countries Word Search
        WordSearchPuzzle::create([
            'title' => 'African Countries',
            'slug' => 'african-countries',
            'description' => 'Find the names of African countries hidden in the grid. Words can be in any direction!',
            'grid_size' => 15,
            'grid' => $this->generateMixedGrid('african_countries'),
            'words' => [
                'GHANA', 'NIGERIA', 'KENYA', 'EGYPT', 'SOUTHAFRICA', 
                'ETHIOPIA', 'MOROCCO', 'TANZANIA', 'UGANDA', 'RWANDA',
                'ZAMBIA', 'ZIMBABWE', 'BOTSWANA', 'NAMIBIA', 'SENEGAL'
            ],
            'word_positions' => [],
            'difficulty' => 'intermediate',
            'points' => 150,
            'time_limit' => 400,
            'attempts_allowed' => 3,
            'is_active' => true,
            'is_featured' => true,
            'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747723/West_African_puzzle_game_promotion_zrgfhv.png',
        ]);

        // African Capitals Word Search
        WordSearchPuzzle::create([
            'title' => 'African Capitals',
            'slug' => 'african-capitals',
            'description' => 'Find the capital cities of African countries hidden in the grid. Words can be in any direction!',
            'grid_size' => 14,
            'grid' => $this->generateMixedGrid('african_capitals'),
            'words' => [
                'ACCRA', 'ABUJA', 'NAIROBI', 'CAIRO', 'PRETORIA',
                'ADDISABABA', 'RABAT', 'DODOMA', 'KAMPALA', 'KIGALI',
                'LUSAKA', 'HARARE', 'GABORONE', 'WINDHOEK', 'DAKAR'
            ],
            'word_positions' => [],
            'difficulty' => 'intermediate',
            'points' => 150,
            'time_limit' => 400,
            'attempts_allowed' => 3,
            'is_active' => true,
            'is_featured' => true,
            'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1773747193/a89b2db3-c78d-423e-b002-70bac096fc97_hkoukl.png',
        ]);

        // African Animals Word Search
        WordSearchPuzzle::create([
            'title' => 'African Animals',
            'slug' => 'african-animals',
            'description' => 'Find the names of magnificent African wildlife hidden in the grid. Words can be in any direction!',
            'grid_size' => 12,
            'grid' => $this->generateMixedGrid('african_animals'),
            'words' => [
                'LION', 'ELEPHANT', 'GIRAFFE', 'ZEBRA', 'RHINOCEROS',
                'LEOPARD', 'CHEETAH', 'HIPPOPOTAMUS', 'CROCODILE', 'GORILLA',
                'CHIMPANZEE', 'WILDEBEEST', 'IMPALA', 'HYENA', 'BABOON'
            ],
            'word_positions' => [],
            'difficulty' => 'beginner',
            'points' => 100,
            'time_limit' => 400,
            'attempts_allowed' => 5,
            'is_active' => true,
            'is_featured' => false,
            'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1774356458/African_wildlife_puzzle_adventure_pqxbzd.png',
        ]);

        // African Landmarks Word Search
        WordSearchPuzzle::create([
            'title' => 'African Landmarks',
            'slug' => 'african-landmarks',
            'description' => 'Find famous African landmarks and natural wonders hidden in the grid. Words can be in any direction!',
            'grid_size' => 16,
            'grid' => $this->generateMixedGrid('african_landmarks'),
            'words' => [
                'PYRAMIDS', 'VICTORIAFALLS', 'KILIMANJARO', 'SERENGETI', 'SAHARA',
                'TABLEMOUNTAIN', 'MASAIMARA', 'OKAVANGO', 'ZAMBEZI', 'NILE',
                'ATLASMOUNTAINS', 'CONGOBASIN', 'LAKEVICTORIA', 'MADAGASCAR', 'CAPETOWN'
            ],
            'word_positions' => [],
            'difficulty' => 'advanced',
            'points' => 200,
            'time_limit' => 400,
            'attempts_allowed' => 3,
            'is_active' => true,
            'is_featured' => true,
            'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1774356699/African_landmarks_puzzle_adventure_1_c6dreg.png',
        ]);

        // African Cultures Word Search
        WordSearchPuzzle::create([
            'title' => 'African Cultures',
            'slug' => 'african-cultures',
            'description' => 'Find words related to African cultures, traditions, and heritage. Words can be in any direction!',
            'grid_size' => 14,
            'grid' => $this->generateMixedGrid('african_cultures'),
            'words' => [
                'KENTE', 'ANKARA', 'DJEMBE', 'SAHARA', 'ASANTE',
                'ZULU', 'MAASAI', 'HIMBA', 'TRIBES', 'DRUMS',
                'BEADS', 'MASKS', 'DANCE', 'RITUALS', 'FESTIVAL'
            ],
            'word_positions' => [],
            'difficulty' => 'intermediate',
            'points' => 150,
            'time_limit' => 400,
            'attempts_allowed' => 3,
            'is_active' => true,
            'is_featured' => false,
            'featured_image' => 'https://res.cloudinary.com/dvsacegwf/image/upload/v1774356570/African_culture_puzzle_celebration_ug6wtt.png',
        ]);
    }

    /**
     * Generate a grid with words placed in random directions
     */
    private function generateMixedGrid($puzzleType)
    {
        // Define words for each puzzle type
        $words = match($puzzleType) {
            'african_countries' => [
                'GHANA', 'NIGERIA', 'KENYA', 'EGYPT', 'SOUTHAFRICA', 
                'ETHIOPIA', 'MOROCCO', 'TANZANIA', 'UGANDA', 'RWANDA',
                'ZAMBIA', 'ZIMBABWE', 'BOTSWANA', 'NAMIBIA', 'SENEGAL'
            ],
            'african_capitals' => [
                'ACCRA', 'ABUJA', 'NAIROBI', 'CAIRO', 'PRETORIA',
                'ADDISABABA', 'RABAT', 'DODOMA', 'KAMPALA', 'KIGALI',
                'LUSAKA', 'HARARE', 'GABORONE', 'WINDHOEK', 'DAKAR'
            ],
            'african_animals' => [
                'LION', 'ELEPHANT', 'GIRAFFE', 'ZEBRA', 'RHINOCEROS',
                'LEOPARD', 'CHEETAH', 'HIPPOPOTAMUS', 'CROCODILE', 'GORILLA',
                'CHIMPANZEE', 'WILDEBEEST', 'IMPALA', 'HYENA', 'BABOON'
            ],
            'african_landmarks' => [
                'PYRAMIDS', 'VICTORIAFALLS', 'KILIMANJARO', 'SERENGETI', 'SAHARA',
                'TABLEMOUNTAIN', 'MASAIMARA', 'OKAVANGO', 'ZAMBEZI', 'NILE',
                'ATLASMOUNTAINS', 'CONGOBASIN', 'LAKEVICTORIA', 'MADAGASCAR', 'CAPETOWN'
            ],
            'african_cultures' => [
                'KENTE', 'ANKARA', 'DJEMBE', 'SAHARA', 'ASANTE',
                'ZULU', 'MAASAI', 'HIMBA', 'TRIBES', 'DRUMS',
                'BEADS', 'MASKS', 'DANCE', 'RITUALS', 'FESTIVAL'
            ],
            default => []
        };

        // Determine grid size based on puzzle type
        $gridSize = match($puzzleType) {
            'african_animals' => 12,
            'african_capitals', 'african_cultures' => 14,
            'african_countries' => 15,
            'african_landmarks' => 16,
            default => 15
        };

        // Create empty grid filled with spaces
        $grid = [];
        for ($i = 0; $i < $gridSize; $i++) {
            $grid[$i] = array_fill(0, $gridSize, ' ');
        }

        // Directions
        $directions = [
            [0, 1],  
            [1, 0],  
            [1, 1],  
            [0, -1], 
            [-1, 0], 
            [-1, -1], 
            [1, -1],  
            [-1, 1]   
        ];

        // Place each word in a random direction
        foreach ($words as $word) {
            $placed = false;
            $attempts = 0;
            $wordLength = strlen($word);
            
            while (!$placed && $attempts < 100) {
                // Choose random direction
                $dir = $directions[array_rand($directions)];
                $rowChange = $dir[0];
                $colChange = $dir[1];
                
                if ($rowChange > 0) {
                    $maxRow = $gridSize - $wordLength;
                    $minRow = 0;
                } elseif ($rowChange < 0) {
                    $maxRow = $wordLength - 1;
                    $minRow = 0;
                } else {
                    $maxRow = $gridSize - 1;
                    $minRow = 0;
                }
                
                if ($colChange > 0) {
                    $maxCol = $gridSize - $wordLength;
                    $minCol = 0;
                } elseif ($colChange < 0) {
                    $maxCol = $wordLength - 1;
                    $minCol = 0;
                } else {
                    $maxCol = $gridSize - 1;
                    $minCol = 0;
                }
                
                if ($maxRow < 0 || $maxCol < 0) {
                    $attempts++;
                    continue;
                }
                
                $startRow = rand(0, $maxRow);
                $startCol = rand(0, $maxCol);
                
                // Adjust for negative direction
                if ($rowChange < 0) {
                    $startRow = rand($wordLength - 1, $gridSize - 1);
                }
                if ($colChange < 0) {
                    $startCol = rand($wordLength - 1, $gridSize - 1);
                }
            
                $canPlace = true;
                for ($i = 0; $i < $wordLength; $i++) {
                    $row = $startRow + ($i * $rowChange);
                    $col = $startCol + ($i * $colChange);
                    
                    if ($row < 0 || $row >= $gridSize || $col < 0 || $col >= $gridSize) {
                        $canPlace = false;
                        break;
                    }
                    
                    $currentChar = $grid[$row][$col];
                    $wordChar = $word[$i];
                    
                    if ($currentChar !== ' ' && $currentChar !== $wordChar) {
                        $canPlace = false;
                        break;
                    }
                }
                
                // Place the word
                if ($canPlace) {
                    for ($i = 0; $i < $wordLength; $i++) {
                        $row = $startRow + ($i * $rowChange);
                        $col = $startCol + ($i * $colChange);
                        $grid[$row][$col] = $word[$i];
                    }
                    $placed = true;
                }
                
                $attempts++;
            }

            if (!$placed) {
                for ($row = 0; $row < $gridSize && !$placed; $row++) {
                    for ($col = 0; $col <= $gridSize - $wordLength; $col++) {
                        $canPlace = true;
                        for ($i = 0; $i < $wordLength; $i++) {
                            if ($grid[$row][$col + $i] !== ' ' && $grid[$row][$col + $i] !== $word[$i]) {
                                $canPlace = false;
                                break;
                            }
                        }
                        if ($canPlace) {
                            for ($i = 0; $i < $wordLength; $i++) {
                                $grid[$row][$col + $i] = $word[$i];
                            }
                            $placed = true;
                            break;
                        }
                    }
                }
            }
        }

        // Fill empty cells with random letters
        $letters = range('A', 'Z');
        for ($i = 0; $i < $gridSize; $i++) {
            for ($j = 0; $j < $gridSize; $j++) {
                if ($grid[$i][$j] === ' ') {
                    $grid[$i][$j] = $letters[array_rand($letters)];
                }
            }
        }
        
        return json_encode($grid);
    }
}