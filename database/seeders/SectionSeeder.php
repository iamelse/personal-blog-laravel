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
            ['name' => 'about', 'content' => json_encode(['title' => 'About Me', 'image' => 'null' ,'description' => "Hello! I'm Lana Septiana, a passionate Laravel Web Developer with over X years of experience in building scalable and high-performance web applications. I specialize in Laravel and have extensive knowledge in web technologies like MySQL, JavaScript, and modern front-end tools such as Tailwind CSS and Bootstrap. My expertise allows me to create clean, maintainable, and optimized code for long-term success.Throughout my career, I've worked on a variety of projects, collaborating with teams to deliver exceptional user experiences. I am always eager to learn and grow, and I strive to implement industry best practices to achieve optimal results. I'm committed to creating value through my work and continuously improving my skills."])],
        ];

        foreach ($sections as $section) {
            Section::updateOrCreate(['name' => $section['name']], $section);
        }
    }
}
