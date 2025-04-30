<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\PostCategory\StorePostCategoryRequest;
use App\Http\Requests\Web\PostCategory\UpdatePostCategoryRequest;
use App\Models\PostCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class PostCategoryController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize(PermissionEnum::READ_POST_CATEGORY->value);

        $allowedFilterFields = ['name'];
        $allowedSortFields = ['name', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];

        $postCategories = PostCategory::search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'name',
            sort_order: $request->sort_order ?? 'ASC'
        )->paginate($request->query('limit') ?? 10);

        return view('pages.post-category.index', [
            'title' => 'Post Category',
            'postCategories' => $postCategories,
            'allowedFilterFields' => $allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits
        ]);
    }

    public function create(): View
    {
        Gate::authorize(PermissionEnum::CREATE_POST_CATEGORY->value);

        return view('pages.post-category.create', [
            'title' => 'New Post Category',
        ]);
    }

    public function store(StorePostCategoryRequest $request): RedirectResponse
    {
        Gate::authorize(PermissionEnum::CREATE_POST_CATEGORY->value);

        try {
            PostCategory::create([
                'name' => $request->name,
                'slug' => $request->slug
            ]);

            return redirect()->route('be.post-category.create')
                ->with('success','Post category created successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.post-create.create')
                ->with('error', $exception->getMessage());
        }
    }

    public function edit(PostCategory $postCategory): View
    {
        Gate::authorize(PermissionEnum::UPDATE_POST_CATEGORY->value);

        return view('pages.post-category.edit', [
            'title' => 'Edit Post Category',
            'postCategory' => $postCategory
        ]);
    }

    public function update(UpdatePostCategoryRequest $request, PostCategory $postCategory): RedirectResponse
    {
        Gate::authorize(PermissionEnum::UPDATE_POST_CATEGORY->value);

        try {
            $updatePostCategoryData = [
                'name' => $request->name,
                'slug' => $request->slug
            ];

            $postCategory->update($updatePostCategoryData);

            return redirect()->route('be.post-category.edit', $postCategory->slug)
                ->with('success','Post category updated');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.post-category.edit', $postCategory->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_POST_CATEGORY->value);

        try {
            $postCategory->delete();

            return redirect()
                ->route('be.post-category.index')
                ->with('success', 'Post category deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting post category (slug: {$postCategory->slug}): " . $e->getMessage());

            return redirect()
                ->route('be.post-category.index')
                ->with('error', 'An error occurred while deleting the post category.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_POST_CATEGORY->value);

        try {
            $postCategoryArray = explode(',', $request->input('slugs', ''));

            if (!empty($postCategoryArray)) {
                PostCategory::whereIn('slug', $postCategoryArray)->delete();
            }

            return redirect()
                ->route('be.post-category.index')
                ->with('success', 'Post categories deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());
            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting post categories: '. $e->getMessage());
            return redirect()
                ->route('be.post-categories.index')
                ->with('error', 'An error occurred while deleting the post categories.');
        }

    }
}
