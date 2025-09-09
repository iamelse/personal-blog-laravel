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
            ['name' => 'Home', 'url' => config('app.url')],
            ['name' => 'About', 'url' => config('app.url') . '/about'],
            ['name' => 'Post', 'url' => config('app.url') . '/post'],
        ];

        foreach ($quickLinks as &$quickLink) {
            $quickLink['slug'] = Str::slug($quickLink['name']);
        }

        QuickLink::insert($quickLinks);
    }
}
