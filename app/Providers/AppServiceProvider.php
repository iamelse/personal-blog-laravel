<?php

namespace App\Providers;

use App\Models\Section;
use App\Models\SocialMedia;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        $socialMedia = SocialMedia::all();

        View::share([
            'footer' => $footer,
            'socialMedia' => $socialMedia
        ]);
    }
}
