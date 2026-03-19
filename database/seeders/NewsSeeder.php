<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run()
    {
        $news = [
            [
                'title' => "Africa's Economic Growth Projections for 2024",
                'slug' => Str::slug("Africa's Economic Growth Projections for 2024"),
                'excerpt' => 'The African Development Bank projects strong growth across the continent, with East Africa leading the way at 5.1%.',
                'content' => 'The African Development Bank has released its latest economic outlook report, projecting robust growth across the continent for 2024. East Africa is expected to lead with a 5.1% growth rate, followed by West Africa at 4.8%, North Africa at 4.2%, and Southern Africa at 3.5%.

Key drivers of this growth include increased investment in infrastructure, growing digital economy and tech innovation, expansion of intra-African trade under AfCFTA, and recovery in tourism and service sectors.

The report also highlights challenges including global inflation pressures, climate change impacts, and the need for continued policy reforms to sustain growth momentum.',
                'category' => 'Economic Development',
                'category_color' => 'indigo',
                'author' => 'African Development Bank',
                'published_date' => '2024-03-15',
                'is_featured' => true,
                'is_published' => true
            ],
            [
                'title' => 'New Trade Corridor Connects West and East Africa',
                'slug' => Str::slug('New Trade Corridor Connects West and East Africa'),
                'excerpt' => 'The new infrastructure project aims to reduce transport costs by 30% and boost intra-African trade.',
                'content' => 'A landmark infrastructure project has been completed, creating a direct trade corridor connecting West and East Africa. The corridor spans 4,500 kilometers, linking major ports in Lagos, Nigeria to Mombasa, Kenya.

Key benefits include a 30% reduction in transport costs, 50% reduction in transit time, creation of 50,000 direct jobs, and a boost to regional trade estimated at $2.5 billion annually.

The project includes modernized border posts, improved roads, and digital tracking systems to streamline cargo movement.',
                'category' => 'Trade & Investment',
                'category_color' => 'green',
                'author' => 'AfCFTA Secretariat',
                'published_date' => '2024-03-12',
                'is_featured' => true,
                'is_published' => true
            ],
            [
                'title' => 'African Tech Startups Raise $1.2B in Q1 2024',
                'slug' => Str::slug('African Tech Startups Raise $1.2B in Q1 2024'),
                'excerpt' => 'Fintech and clean energy sectors lead the investment surge as African innovation continues to attract global attention.',
                'content' => 'African tech startups have raised a record $1.2 billion in the first quarter of 2024, representing a 40% increase compared to the same period last year.

Sector breakdown shows Fintech leading with $650 million (54%), followed by Clean Energy at $250 million (21%), E-commerce at $150 million (12.5%), Healthtech at $80 million (6.7%), and other sectors at $70 million (5.8%).

Nigeria, Kenya, South Africa, and Egypt continue to lead in deal volume, but emerging ecosystems in Ghana, Rwanda, and Senegal are showing significant growth.',
                'category' => 'Technology',
                'category_color' => 'blue',
                'author' => 'TechCrunch Africa',
                'published_date' => '2024-03-10',
                'is_featured' => false,
                'is_published' => true
            ],
            [
                'title' => 'Continental High-Speed Rail Network Announced',
                'slug' => Str::slug('Continental High-Speed Rail Network Announced'),
                'excerpt' => 'Phase one will connect 8 major economic hubs, creating thousands of jobs and boosting regional integration.',
                'content' => 'The African Union has announced an ambitious high-speed rail network that will eventually connect all 55 member states. Phase one will link 8 major economic hubs across West, East, and Southern Africa.

Phase one routes include Lagos - Abidjan - Accra, Nairobi - Mombasa - Kampala, Johannesburg - Gaborone - Harare, and Casablanca - Algiers - Tunis.

The project is expected to create 200,000 direct jobs during construction and boost intra-African trade by an estimated 40% upon completion.',
                'category' => 'Infrastructure',
                'category_color' => 'purple',
                'author' => 'African Union',
                'published_date' => '2024-03-08',
                'is_featured' => false,
                'is_published' => true
            ],
        ];

        foreach ($news as $item) {
            News::create($item);
        }
    }
}