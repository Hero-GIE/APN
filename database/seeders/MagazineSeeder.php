<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Magazine;
use Illuminate\Support\Facades\Storage;

class MagazineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {      
        
        $publications = [
            [
                'title' => 'APD 2026 Magazine',
                'type' => 'magazine',
                'file_path' => 'magazines/apd-magazine.pdf',
                'is_active' => true,
            ],
            
            // Example of a report
            [
                'title' => 'Annual Report 2025',
                'type' => 'report',
                'file_path' => 'reports/apd-magazine.pdf',
                'is_active' => true,
            ],
            
            // Example of a newsletter
            [
                'title' => 'March 2026 Newsletter',
                'type' => 'newsletter',
                'file_path' => 'newsletters/apd-magazine.pdf',
                'is_active' => true,
            ],
        ];

        $count = 0;
        foreach ($publications as $publication) {
            if (Storage::disk('public')->exists($publication['file_path'])) {
                Magazine::create($publication);
                $count++;
                $this->command->info("Added: {$publication['title']}");
            } else {
                $this->command->warn("File not found: {$publication['file_path']}");
            }
        }

        $this->command->info("Successfully added {$count} publications to the database!");
    }
}