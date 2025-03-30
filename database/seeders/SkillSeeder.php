<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            ['name' => 'Laravel', 'slug' => Str::slug('Laravel'), 'icon_class' => 'devicon-laravel-original colored'],
            ['name' => 'MySQL', 'slug' => Str::slug('MySQL'), 'icon_class' => 'devicon-mysql-original colored'],
            ['name' => 'HTML', 'slug' => Str::slug('HTML'), 'icon_class' => 'devicon-html5-plain colored'],
            ['name' => 'Tailwind', 'slug' => Str::slug('Tailwind'), 'icon_class' => 'devicon-tailwindcss-original colored'],
            ['name' => 'Bootstrap', 'slug' => Str::slug('Bootstrap'), 'icon_class' => 'devicon-bootstrap-plain colored'],
            ['name' => 'JavaScript', 'slug' => Str::slug('JavaScript'), 'icon_class' => 'devicon-javascript-plain colored'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
