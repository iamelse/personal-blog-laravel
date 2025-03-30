<?php

namespace App\Providers;

use App\Models\Section;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $footer = Section::where('name', 'footer')->first();
        $socialMedia = Schema::hasTable('social_media') ? SocialMedia::all() : collect([]);

        View::share([
            'footer' => $footer,
            'socialMedia' => $socialMedia
        ]);
    }
}