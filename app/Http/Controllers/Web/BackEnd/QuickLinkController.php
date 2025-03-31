<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\QuickLink\StoreQuickLinkRequest;
use App\Http\Requests\Web\QuickLink\UpdateQuickLinkRequest;
use App\Models\QuickLink;
use Cviebrock\EloquentSluggable\Services\SlugService;
use FFI\Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class QuickLinkController extends Controller
{
    public function index(Request $request): View | RedirectResponse
    {
        Gate::authorize(PermissionEnum::READ_QUICK_LINK->value);

        $allowedFilterFields = ['name'];
        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $quickLinks = QuickLink::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'name',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.quick-link.index', [
            'title' => 'Quick Links',
            'quickLinks' => $quickLinks,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_QUICK_LINK->value);

        return view('pages.quick-link.create', [
            'title' => 'New Quick Link',
        ]);
    }

    public function store(StoreQuickLinkRequest $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::CREATE_QUICK_LINK);

            QuickLink::create([
                'name' => $request->name,
                'url' => $request->url,
            ]);

            return redirect()->route('be.quick-link.create')
                ->with('success','Quick link created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.quick-link.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(QuickLink $quickLink): View
    {
        Gate::authorize(PermissionEnum::UPDATE_QUICK_LINK->value);

        return view('pages.quick-link.edit', [
            'title' => 'Edit Quick Link | '. $quickLink->name,
            'quickLink' => $quickLink,
        ]);
    }

    public function update(UpdateQuickLinkRequest $request, QuickLink $quickLink): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::UPDATE_QUICK_LINK->value);

            QuickLink::where('slug', $quickLink->slug)->update([
                'name' => $request->name,
                'slug' => $request->slug,
                'url' => $request->url
            ]);
            
            return redirect()->route('be.quick-link.edit', $request->slug ?? $quickLink->slug)
                ->with('success','Quick link updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.quick-link.edit', $quickLink->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(QuickLink $quickLink): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_QUICK_LINK->value);

            $quickLink->delete();

            return redirect()
                ->route('be.quick-link.index')
                ->with('success', 'Quick link deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());

                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error("Error deleting quick link (Name: {$quickLink->name}): " . $e->getMessage());

            return redirect()
                ->route('be.quick-link.index')
                ->with('error', 'An error occurred while deleting the quick link.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        try {
            Gate::authorize(PermissionEnum::DELETE_QUICK_LINK->value);

            $quickLinkArray = explode(',', $request->input('slugs', ''));

            if (!empty($quickLinkArray)) {
                QuickLink::whereIn('slug', $quickLinkArray)->delete();
            }

            return redirect()
                ->route('be.quick-link.index')
                ->with('success', 'Quick links deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
                Log::error($authorizationException->getMessage());
                abort(403, 'This action is unauthorized.');
        } catch (Exception $e) {
            Log::error('Error deleting quick links: '. $e->getMessage());
            return redirect()
                ->route('be.quick-link.index')
                ->with('error', 'An error occurred while deleting the quick links.');
        }
    }

    public function generateSlug(Request $request): JsonResponse
    {
        $slug = SlugService::createSlug(QuickLink::class, 'slug', $request->name);

        return response()->json(['slug' => $slug]);
    }
}
