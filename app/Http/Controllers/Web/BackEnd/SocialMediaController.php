<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\SocialMedia\StoreSocialMediaRequest;
use App\Http\Requests\Web\SocialMedia\UpdateSocialMediaRequest;
use App\Models\SocialMedia;
use Cviebrock\EloquentSluggable\Services\SlugService;
use FFI\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SocialMediaController extends Controller
{
    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_SOCIAL_MEDIA->value);

        $allowedFilterFields = ['name'];
        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $socialMedias = SocialMedia::search(
                keyword: $request->keyword,
                columns: $allowedFilterFields,
            )->sort(
                sort_by: $request->sort_by ?? 'name',
                sort_order: $request->sort_order ?? 'ASC'
            )->paginate($request->query('limit') ?? 10);

        return view('pages.social-media.index', [
            'title' => 'Social Media',
            'socialMedias' => $socialMedias,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_SOCIAL_MEDIA);

        return view('pages.social-media.create', [
            'title'=> 'New Social Media',
        ]);
    }

    public function store(StoreSocialMediaRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_SOCIAL_MEDIA);

            SocialMedia::create([
                'name' => $request->name,
                'icon' => $request->icon,
                'url' => $request->url,
            ]);

            return redirect()->route('be.social-media.create')
                ->with('success','Social media created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.social-media.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(SocialMedia $socialMedia): View
    {
        Gate::authorize(PermissionEnum::UPDATE_SOCIAL_MEDIA->value);

        return view('pages.social-media.edit', [
            'title' => 'Edit Social Media | '. $socialMedia->name,
            'socialMedia' => $socialMedia,
        ]);
    }

    public function update(UpdateSocialMediaRequest $request, SocialMedia $socialMedia): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_SOCIAL_MEDIA->value);

            SocialMedia::where('slug', $socialMedia->slug)->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'icon' => $request->icon,
                'url' => $request->url,
            ]);
            
            return redirect()->route('be.social-media.edit', $request->slug ?? $socialMedia->slug)
                ->with('success','Social media updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.social-media.edit', $socialMedia->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(SocialMedia $socialMedia): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_SOCIAL_MEDIA->value);

            $socialMedia->delete();

            return redirect()
                ->route('be.social-media.index')
                ->with('success', 'Social media deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());

                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error("Error deleting social media (Name: {$socialMedia->name}): " . $e->getMessage());

            return redirect()
                ->route('be.social-media.index')
                ->with('error', 'An error occurred while deleting the social media.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_SOCIAL_MEDIA->value);

            $socialMediaArray = explode(',', $request->input('slugs', ''));

            if (!empty($socialMediaArray)) {
                SocialMedia::whereIn('slug', $socialMediaArray)->delete();
            }

            return redirect()
                ->route('be.social-media.index')
                ->with('success', 'Skills deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());
                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error deleting social medias: '. $e->getMessage());
            return redirect()
                ->route('be.social-media.index')
                ->with('error', 'An error occurred while deleting the skills.');
        }
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(SocialMedia::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
