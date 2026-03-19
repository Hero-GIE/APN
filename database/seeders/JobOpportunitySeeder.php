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
                'description' => "<p>We are seeking an experienced Regional Director to lead our East Africa operations. The ideal candidate will have a proven track record in strategic leadership, partnership development, and regional program management.</p>
                <h4>Key Responsibilities:</h4>
                <ul>
                    <li>Develop and implement regional strategy aligned with organizational goals</li>
                    <li>Manage relationships with government partners, donors, and stakeholders</li>
                    <li>Oversee program implementation across 5+ countries</li>
                    <li>Lead and mentor a diverse team of professionals</li>
                    <li>Ensure compliance with local regulations and organizational policies</li>
                </ul>
                <h4>Qualifications:</h4>
                <ul>
                    <li>10+ years of senior leadership experience</li>
                    <li>Master's degree in Business, Economics, or related field</li>
                    <li>Deep understanding of East African economic landscape</li>
                    <li>Excellent stakeholder management and negotiation skills</li>
                </ul>",
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
                'description' => "<p>Africa50 is seeking a Senior Investment Analyst to join our growing team. You will play a key role in identifying, analyzing, and executing infrastructure investment opportunities across Africa.</p>
                <h4>Key Responsibilities:</h4>
                <ul>
                    <li>Conduct financial modeling and valuation analysis</li>
                    <li>Perform due diligence on potential investments</li>
                    <li>Prepare investment memos and presentations</li>
                    <li>Monitor portfolio company performance</li>
                    <li>Support deal execution and closing</li>
                </ul>
                <h4>Qualifications:</h4>
                <ul>
                    <li>3-5 years of investment banking or private equity experience</li>
                    <li>CFA or MBA preferred</li>
                    <li>Strong financial modeling skills</li>
                    <li>Knowledge of infrastructure sectors (energy, transport, digital)</li>
                </ul>",
                'company' => 'Africa50',
                'location' => 'Casablanca, Morocco',
                'city' => 'Casablanca',
                'country' => 'Morocco',
                'job_type' => 'Full-time',
                'category' => 'Finance',
                'category_color' => 'purple',
                'experience_level' => 'Senior Level',
                'salary_range' => '$80k - $100k',
                'badge_type' => null,
                'badge_color' => null,  // This is causing the error
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
                'description' => "<p>Ecobank is looking for a visionary leader to drive our digital transformation agenda across the continent. This role will shape the future of banking in Africa through innovative technology solutions.</p>
                <h4>Key Responsibilities:</h4>
                <ul>
                    <li>Develop and execute digital transformation strategy</li>
                    <li>Lead implementation of new banking technologies</li>
                    <li>Drive customer-centric digital innovation</li>
                    <li>Manage digital product development teams</li>
                    <li>Collaborate with fintech partners and regulators</li>
                </ul>
                <h4>Qualifications:</h4>
                <ul>
                    <li>8+ years in digital transformation, preferably in banking</li>
                    <li>Proven track record of successful digital initiatives</li>
                    <li>Deep understanding of African markets</li>
                    <li>Strong leadership and change management skills</li>
                </ul>",
                'company' => 'Ecobank',
                'location' => 'Lagos, Nigeria',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'job_type' => 'Full-time',
                'category' => 'Technology',
                'category_color' => 'blue',
                'experience_level' => 'Senior Level',
                'salary_range' => 'Competitive',
                'badge_type' => 'Urgent',
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
                'description' => "<p>McKinsey & Company is seeking a Sustainability Consultant to join our Africa practice. You will work with leading organizations across the continent to develop and implement sustainable business strategies.</p>
                <h4>Key Responsibilities:</h4>
                <ul>
                    <li>Advise clients on ESG strategy and implementation</li>
                    <li>Conduct sustainability assessments and gap analyses</li>
                    <li>Develop carbon reduction strategies</li>
                    <li>Support clients in sustainability reporting</li>
                    <li>Stay current on global sustainability trends and regulations</li>
                </ul>
                <h4>Qualifications:</h4>
                <ul>
                    <li>5-7 years of consulting experience</li>
                    <li>Strong expertise in sustainability and ESG</li>
                    <li>MBA or advanced degree preferred</li>
                    <li>Excellent communication and presentation skills</li>
                </ul>",
                'company' => 'McKinsey & Company',
                'location' => 'Johannesburg, South Africa',
                'city' => 'Johannesburg',
                'country' => 'South Africa',
                'job_type' => 'Full-time',
                'category' => 'Consulting',
                'category_color' => 'green',
                'experience_level' => 'Senior Level',
                'salary_range' => '$90k - $120k',
                'badge_type' => null,
                'badge_color' => null,  
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