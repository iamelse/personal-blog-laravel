<?php

namespace App\Providers;

use App\Models\QuickLink;
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
        $footer = Schema::hasTable('sections')
            ? Section::where('name', 'footer')->first()
            : null;

        $socialMedia = Schema::hasTable('social_media')
            ? SocialMedia::all()
            : collect([]);

        $quickLinks = Schema::hasTable('quick_links')
            ? QuickLink::all()
            : collect([]);

        View::share([
            'footer' => $footer,
            'socialMedia' => $socialMedia,
            'quickLinks' => $quickLinks
        ]);
    }
}
