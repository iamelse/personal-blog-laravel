<?php

namespace App\Http\Controllers\Web\BackEnd\About;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\About\UpdateAboutRequest;
use App\Models\Section;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_ABOUT->value);

        $about = Section::where('name', 'about-page.about')->firstOrFail();

        return view('pages.fe-about.index', [
            'title' => 'About',
            'about' => $about
        ]);
    }

    public function update(UpdateAboutRequest $request, Section $section)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_ABOUT->value);

            Section::where('name', 'about-page.about')->update([
                'content' => json_encode([
                    'description' => $request->input('description')
                ])
            ]);

            return redirect()->back()->with('success', 'About updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Failed to update About', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update About. ' . $e->getMessage());
        }
    }
}
