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
            ['name' => 'Twitter', 'icon' => 'bx bxl-twitter', 'url' => 'https://twitter.com/iamelse'],
            ['name' => 'Instagram', 'icon' => 'bx bxl-instagram', 'url' => 'https://instagram.com/iamelse'],
            ['name' => 'Facebook', 'icon' => 'bx bxl-facebook', 'url' => 'https://facebook.com/iamelse'],
            ['name' => 'YouTube', 'icon' => 'bx bxl-youtube', 'url' => 'https://youtube.com/iamelse'],
            ['name' => 'Reddit', 'icon' => 'bx bxl-reddit', 'url' => 'https://reddit.com/u/iamelse'],
            ['name' => 'TikTok', 'icon' => 'bx bxl-tiktok', 'url' => 'https://tiktok.com/@iamelse'],
            ['name' => 'Snapchat', 'icon' => 'bx bxl-snapchat', 'url' => 'https://snapchat.com/add/iamelse'],
            ['name' => 'Pinterest', 'icon' => 'bx bxl-pinterest', 'url' => 'https://pinterest.com/iamelse'],
        ];

        foreach ($socialMedias as &$socialMedia) {
            $socialMedia['slug'] = Str::slug($socialMedia['name']);
        }

        SocialMedia::insert($socialMedias);
    }
}
