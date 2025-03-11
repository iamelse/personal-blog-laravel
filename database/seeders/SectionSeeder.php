<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sections = [
            ['name' => 'hero', 'content' => json_encode(['title' => 'Laravel Web Developer Expert', 'description' => "Hi, I'm Lana Septiana, a passionate and experienced Laravel Web Developer specializing in building scalable, high-performance web applications. I am committed to writing clean, maintainable code and following best practices to ensure long-term scalability and performance."])],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(['name' => $section['name']], $section);
        }
    }
}
