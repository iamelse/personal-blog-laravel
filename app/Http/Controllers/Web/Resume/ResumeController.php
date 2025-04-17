<?php

namespace App\Http\Controllers\Web\Resume;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Resume\UpdateResumeRequest;
use App\Models\Section;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ResumeController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_RESUME->value);

        $resume = Section::where('name', 'resume-page.resume')->firstOrFail();

        return view('pages.fe-resume.index', [
            'title' => 'Resume',
            'resume' => $resume
        ]);
    }

    public function update(UpdateResumeRequest $request, Section $section)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_RESUME->value);

            Section::where('name', 'resume-page.resume')->update([
                'content' => json_encode([
                    'description' => $request->input('description')
                ])
            ]);

            return redirect()->back()->with('success', 'Resume updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Failed to update Resume', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update Resume. ' . $e->getMessage());
        }
    }
}
