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
            ['name' => 'Laravel', 'icon_class' => 'devicon-laravel-original colored'],
            ['name' => 'MySQL', 'icon_class' => 'devicon-mysql-original colored'],
            ['name' => 'HTML', 'icon_class' => 'devicon-html5-plain colored'],
            ['name' => 'Tailwind', 'icon_class' => 'devicon-tailwindcss-original colored'],
            ['name' => 'Bootstrap', 'icon_class' => 'devicon-bootstrap-plain colored'],
            ['name' => 'JavaScript', 'icon_class' => 'devicon-javascript-plain colored'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
