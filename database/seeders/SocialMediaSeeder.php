<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SocialMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $socialMedias = [
            ['name' => 'LinkedIn', 'icon' => 'bx bxl-linkedin', 'url' => 'https://www.linkedin.com/in/iamelse'],
            ['name' => 'GitHub', 'icon' => 'bx bxl-github', 'url' => 'https://github.com/iamelse'],
            ['name' => 'Instagram', 'icon' => 'bx bxl-instagram', 'url' => 'https://instagram.com/elsedev'],
        ];

        foreach ($socialMedias as &$socialMedia) {
            $socialMedia['slug'] = Str::slug($socialMedia['name']);
        }

        SocialMedia::insert($socialMedias);
    }
}
