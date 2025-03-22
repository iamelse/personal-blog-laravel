<?php

namespace App\Http\Controllers\Web\BackEnd\Home;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Home\UpdateFooterRequest;
use App\Models\Section;
use FFI\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FooterController extends Controller
{
    public function index(): View
    {
        Gate::authorize(PermissionEnum::UPDATE_HOME_FOOTER->value);

        $footer = Section::where('name', 'footer')->firstOrFail();
        
        return view('pages.fe-home.footer', [
            'title' => 'Home | Footer',
            'footer' => $footer
        ]);
    }

    public function update(UpdateFooterRequest $request, Section $section)
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_HOME_FOOTER->value);

            $section = Section::where('name', 'footer')->firstOrFail();
            $content = $request->validated()['content'];

            $section->content = json_encode($content);
            $section->save();
    
            return redirect()->back()->with('success', 'Footer updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Failed to update Footer section', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('error', 'Failed to update Footer. ' . $e->getMessage());
        }
    }
}
