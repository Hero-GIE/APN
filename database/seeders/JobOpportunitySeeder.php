<?php

namespace Database\Seeders;

use App\Models\JobOpportunity;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class JobOpportunitySeeder extends Seeder
{
    public function run()
    {
        $jobs = [
            [
                'title' => 'Regional Director - East Africa',
                'slug' => Str::slug('Regional Director - East Africa'),
                'summary' => 'Lead regional development initiatives and manage strategic partnerships across East Africa.',
                'description' => 'We are seeking an experienced Regional Director to lead our East Africa operations. The ideal candidate will have a proven track record in strategic leadership, partnership development, and regional program management.

Key Responsibilities:
• Develop and implement regional strategy aligned with organizational goals
• Manage relationships with government partners, donors, and stakeholders
• Oversee program implementation across 5+ countries
• Lead and mentor a diverse team of professionals
• Ensure compliance with local regulations and organizational policies

Qualifications:
• 10+ years of senior leadership experience
• Master\'s degree in Business, Economics, or related field
• Deep understanding of East African economic landscape
• Excellent stakeholder management and negotiation skills',
                'company' => 'African Development Bank',
                'location' => 'Nairobi, Kenya',
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'job_type' => 'Full-time',
                'category' => 'Executive',
                'category_color' => 'indigo',
                'experience_level' => 'Executive Level',
                'salary_range' => '$120k - $150k',
                'badge_type' => 'New',
                'badge_color' => 'green',
                'posted_date' => Carbon::now()->subDays(2),
                'application_deadline' => Carbon::now()->addDays(28),
                'application_url' => '#',
                'requirements' => '10+ years experience, Master\'s degree',
                'benefits' => 'Health insurance, 401k matching, Remote work options',
                'is_featured' => true,
                'is_published' => true
            ],
            [
                'title' => 'Senior Investment Analyst',
                'slug' => Str::slug('Senior Investment Analyst'),
                'summary' => 'Analyze investment opportunities in infrastructure projects across the continent.',
                'description' => 'Africa50 is seeking a Senior Investment Analyst to join our growing team. You will play a key role in identifying, analyzing, and executing infrastructure investment opportunities across Africa.

Key Responsibilities:
• Conduct financial modeling and valuation analysis
• Perform due diligence on potential investments
• Prepare investment memos and presentations
• Monitor portfolio company performance
• Support deal execution and closing

Qualifications:
• 3-5 years of investment banking or private equity experience
• CFA or MBA preferred
• Strong financial modeling skills
• Knowledge of infrastructure sectors (energy, transport, digital)',
                'company' => 'Africa50',
                'location' => 'Casablanca, Morocco',
                'city' => 'Casablanca',
                'country' => 'Morocco',
                'job_type' => 'Full-time',
                'category' => 'Finance',
                'category_color' => 'purple',
                'experience_level' => 'Senior Level',
                'salary_range' => '$80k - $100k',
                'badge_type' => 'urgent', 
                'badge_color' => 'green',  
                'posted_date' => Carbon::now()->subDays(5),
                'application_deadline' => Carbon::now()->addDays(25),
                'application_url' => '#',
                'requirements' => '3-5 years experience, CFA/MBA preferred',
                'benefits' => 'Competitive salary, Annual bonus, Relocation assistance',
                'is_featured' => true,
                'is_published' => true
            ],
            [
                'title' => 'Head of Digital Transformation',
                'slug' => Str::slug('Head of Digital Transformation'),
                'summary' => 'Lead digital innovation initiatives across 36 African countries.',
                'description' => 'Ecobank is looking for a visionary leader to drive our digital transformation agenda across the continent. This role will shape the future of banking in Africa through innovative technology solutions.

Key Responsibilities:
• Develop and execute digital transformation strategy
• Lead implementation of new banking technologies
• Drive customer-centric digital innovation
• Manage digital product development teams
• Collaborate with fintech partners and regulators

Qualifications:
• 8+ years in digital transformation, preferably in banking
• Proven track record of successful digital initiatives
• Deep understanding of African markets
• Strong leadership and change management skills',
                'company' => 'Ecobank',
                'location' => 'Lagos, Nigeria',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'job_type' => 'Full-time',
                'category' => 'Technology',
                'category_color' => 'blue',
                'experience_level' => 'Senior Level',
                'salary_range' => 'Competitive',
                'badge_type' => 'urgent',
                'badge_color' => 'orange',
                'posted_date' => Carbon::now()->subDays(7),
                'application_deadline' => Carbon::now()->addDays(21),
                'application_url' => '#',
                'requirements' => '8+ years experience in digital transformation',
                'benefits' => 'Executive benefits package, Housing allowance, Company car',
                'is_featured' => true,
                'is_published' => true
            ],
            [
                'title' => 'Sustainability Consultant',
                'slug' => Str::slug('Sustainability Consultant'),
                'summary' => 'Advise clients on sustainable business practices and ESG strategies.',
                'description' => 'McKinsey & Company is seeking a Sustainability Consultant to join our Africa practice. You will work with leading organizations across the continent to develop and implement sustainable business strategies.

Key Responsibilities:
• Advise clients on ESG strategy and implementation
• Conduct sustainability assessments and gap analyses
• Develop carbon reduction strategies
• Support clients in sustainability reporting
• Stay current on global sustainability trends and regulations

Qualifications:
• 5-7 years of consulting experience
• Strong expertise in sustainability and ESG
• MBA or advanced degree preferred
• Excellent communication and presentation skills',
                'company' => 'McKinsey & Company',
                'location' => 'Johannesburg, South Africa',
                'city' => 'Johannesburg',
                'country' => 'South Africa',
                'job_type' => 'Full-time',
                'category' => 'Consulting',
                'category_color' => 'green',
                'experience_level' => 'Senior Level',
                'salary_range' => '$90k - $120k',
                'badge_type' => 'new', 
                'badge_color' => 'pink',  
                'posted_date' => Carbon::now()->subDays(14),
                'application_deadline' => Carbon::now()->addDays(14),
                'application_url' => '#',
                'requirements' => '5-7 years consulting, ESG expertise',
                'benefits' => 'Global career opportunities, Professional development, Travel opportunities',
                'is_featured' => false,
                'is_published' => true
            ],
        ];

        foreach ($jobs as $job) {
            JobOpportunity::create($job);
        }
    }
}