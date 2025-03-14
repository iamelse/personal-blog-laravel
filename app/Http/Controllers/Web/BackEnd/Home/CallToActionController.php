<?php

namespace App\Http\Controllers\Web\BackEnd\Home;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Home\UpdateCTARequest;
use App\Models\Section;
use FFI\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CallToActionController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_HOME_ABOUT->value);

        $callToAction = Section::where('name', 'cta')->firstOrFail();

        return view('pages.fe-home.call-to-action', [
            'title' => 'Home | Call To Action',
            'callToAction' => $callToAction
        ]);
    }

    public function update(UpdateCTARequest $request, Section $section)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_HOME_CTA->value);

            $section = Section::where('name', 'cta')->firstOrFail();

            $section->content = json_encode($request->validated()['content']);
            $section->save();
    
            return redirect()->back()->with('success', 'CTA section updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Failed to update CTA section', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update CTA section. ' . $e->getMessage());
        }
    }
}
