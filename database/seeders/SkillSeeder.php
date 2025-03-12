<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'Laravel', 'icon_class' => 'devicon-laravel-plain', 'color_light' => 'text-red-600', 'color_dark' => 'text-red-400'],
            ['name' => 'MySQL', 'icon_class' => 'devicon-mysql-plain', 'color_light' => 'text-blue-500', 'color_dark' => 'text-blue-300'],
            ['name' => 'HTML', 'icon_class' => 'devicon-html5-plain', 'color_light' => 'text-orange-500', 'color_dark' => 'text-orange-300'],
            ['name' => 'Tailwind', 'icon_class' => 'devicon-tailwindcss-plain', 'color_light' => 'text-teal-500', 'color_dark' => 'text-teal-300'],
            ['name' => 'Bootstrap', 'icon_class' => 'devicon-bootstrap-plain', 'color_light' => 'text-purple-600', 'color_dark' => 'text-purple-400'],
            ['name' => 'JavaScript', 'icon_class' => 'devicon-javascript-plain', 'color_light' => 'text-yellow-500', 'color_dark' => 'text-yellow-400'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
