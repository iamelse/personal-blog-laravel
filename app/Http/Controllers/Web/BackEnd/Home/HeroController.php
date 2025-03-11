<?php

namespace App\Http\Controllers\Web\BackEnd\Home;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Home\UpdateHeroRequest;
use App\Models\Section;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HeroController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_HOME_HERO->value);
        
        $hero = Section::where('name', 'hero')->firstOrFail();

        return view('pages.fe-home.hero', [
            'title' => 'Home | Hero',
            'hero' => $hero
        ]);
    }

    public function update(UpdateHeroRequest $request, Section $section)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_HOME_HERO->value);

            $section = Section::where('name', 'hero')->firstOrFail();

            $section->content = json_encode($request->validated()['content']);
            $section->save();
    
            return redirect()->back()->with('success', 'Hero section updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Failed to update Hero section', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update Hero section. ' . $e->getMessage());
        }
    }
}
