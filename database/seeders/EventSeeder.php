<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run()
    {
        $events = [
            [
                'title' => 'Africa Investment Forum 2026',
                'slug' => Str::slug('Africa Investment Forum 2026'),
                'description' => 'Connect with investors and explore opportunities across Africa',
                'category' => 'Conference',
                'type' => 'Virtual',
                'location' => 'Virtual Event',
                'start_date' => Carbon::now()->addDays(15)->setTime(10, 0, 0), 
                'end_date' => Carbon::now()->addDays(15)->setTime(16, 0, 0), 
                'timezone' => 'GMT',
                'organizer' => 'African Development Bank',
                'venue' => 'Online',
                'city' => null,
                'country' => null,
                'capacity' => 5000,
                'price' => 0,
                'is_free_for_members' => true,
                'registration_url' => '#',
                'badge_type' => 'Free for Members',
                'badge_color' => 'green',
                'is_featured' => true,
                'is_published' => true
            ],
            [
                'title' => 'Economic Outlook: East Africa Regional Summit 2026',
                'slug' => Str::slug('Economic Outlook: East Africa Regional Summit 2026'),
                'description' => 'Join policymakers and business leaders discussing regional integration',
                'category' => 'Summit',
                'type' => 'In-person',
                'location' => 'Nairobi, Kenya',
                'start_date' => Carbon::now()->addDays(22)->setTime(9, 0, 0), 
                'end_date' => Carbon::now()->addDays(22)->setTime(17, 0, 0), 
                'timezone' => 'EAT',
                'organizer' => 'East African Community',
                'venue' => 'Kenyatta International Convention Centre',
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'capacity' => 500,
                'price' => 299,
                'is_free_for_members' => false,
                'registration_url' => '#',
                'badge_type' => 'Limited Seats',
                'badge_color' => 'yellow',
                'is_featured' => true,
                'is_published' => true
            ],
            [
                'title' => 'Digital Transformation in African Agriculture 2026',
                'slug' => Str::slug('Digital Transformation in African Agriculture 2026'),
                'description' => 'Explore how technology is revolutionizing farming across the continent',
                'category' => 'Webinar',
                'type' => 'Virtual',
                'location' => 'Webinar',
                'start_date' => Carbon::now()->addDays(28)->setTime(14, 0, 0),
                'end_date' => Carbon::now()->addDays(28)->setTime(15, 30, 0), 
                'timezone' => 'GMT',
                'organizer' => 'Tech4Ag Africa',
                'venue' => 'Zoom',
                'city' => null,
                'country' => null,
                'capacity' => 1000,
                'price' => 0,
                'is_free_for_members' => true,
                'registration_url' => '#',
                'badge_type' => 'Free for Members',
                'badge_color' => 'green',
                'is_featured' => false,
                'is_published' => true
            ],
            [
                'title' => 'Women in Business Leadership Conference 2026',
                'slug' => Str::slug('Women in Business Leadership Conference 2026'),
                'description' => 'Celebrating and empowering women entrepreneurs across Africa',
                'category' => 'Conference',
                'type' => 'Hybrid',
                'location' => 'Accra, Ghana & Virtual',
                'start_date' => Carbon::now()->addDays(35)->setTime(9, 0, 0), 
                'end_date' => Carbon::now()->addDays(35)->setTime(18, 0, 0), 
                'timezone' => 'GMT',
                'organizer' => 'African Women Leadership Network',
                'venue' => 'Accra International Conference Centre',
                'city' => 'Accra',
                'country' => 'Ghana',
                'capacity' => 800,
                'price' => 149,
                'is_free_for_members' => false,
                'registration_url' => '#',
                'badge_type' => 'Early Bird',
                'badge_color' => 'blue',
                'is_featured' => false,
                'is_published' => true
            ],
        ];

        foreach ($events as $event) {
            Event::create($event);
        }
    }
}