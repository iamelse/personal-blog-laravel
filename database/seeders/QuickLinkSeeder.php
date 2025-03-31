<?php

namespace Database\Seeders;

use App\Models\QuickLink;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QuickLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quickLinks = [
            ['name' => 'Home', 'url' => 'https://yourwebsite.com'],
            ['name' => 'About', 'url' => 'https://yourwebsite.com/about'],
            ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/in/iamelse'],
            ['name' => 'GitHub', 'url' => 'https://github.com/iamelse'],
            ['name' => 'Twitter', 'url' => 'https://twitter.com/iamelse'],
            ['name' => 'Instagram', 'url' => 'https://instagram.com/iamelse'],
            ['name' => 'Facebook', 'url' => 'https://facebook.com/iamelse'],
            ['name' => 'YouTube', 'url' => 'https://youtube.com/iamelse'],
            ['name' => 'Reddit', 'url' => 'https://reddit.com/u/iamelse'],
            ['name' => 'TikTok', 'url' => 'https://tiktok.com/@iamelse'],
            ['name' => 'Snapchat', 'url' => 'https://snapchat.com/add/iamelse'],
            ['name' => 'Pinterest', 'url' => 'https://pinterest.com/iamelse'],
        ];

        foreach ($quickLinks as &$quickLink) {
            $quickLink['slug'] = Str::slug($quickLink['name']);
        }

        QuickLink::insert($quickLinks);
    }
}
