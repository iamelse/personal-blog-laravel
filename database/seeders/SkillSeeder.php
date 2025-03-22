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
            ['name' => 'Laravel', 'icon_class' => 'devicon-laravel-plain'],
            ['name' => 'MySQL', 'icon_class' => 'devicon-mysql-plain'],
            ['name' => 'HTML', 'icon_class' => 'devicon-html5-plain'],
            ['name' => 'Tailwind', 'icon_class' => 'devicon-tailwindcss-plain'],
            ['name' => 'Bootstrap', 'icon_class' => 'devicon-bootstrap-plain'],
            ['name' => 'JavaScript', 'icon_class' => 'devicon-javascript-plain'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
