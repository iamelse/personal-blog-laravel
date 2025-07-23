<?php

namespace App\Http\Controllers\Web\BackEnd;

use App\Enums\PermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Post\UpdatePostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    protected array $allowedFilterFields = ['title', 'slug', 'body'];

    private function _getFilteredPosts(Request $request)
    {
        return Post::with('category')
            ->search(
                keyword: $request->keyword,
                columns: $this->allowedFilterFields,
            )
            ->sort(
                sort_by: $request->sort_by ?? 'created_at',
                sort_order: $request->sort_order ?? 'DESC'
            )
            ->when($request->category, fn($query, $category) =>
            $query->whereHas('category', fn($q) => $q->where('slug', $category))
            )
            ->when($request->status, fn($query, $status) =>
            $query->where('status', $status)
            )
            ->paginate($request->query('limit') ?? 10);
    }

    public function index(Request $request): View
    {
        Gate::authorize(PermissionEnum::READ_POST->value);

        $allowedSortFields = ['title', 'created_at', 'updated_at'];
        $limits = [10, 25, 50, 100];
        $postCategories = PostCategory::all();

        $posts = $this->_getFilteredPosts($request);

        return view('pages.post.index', [
            'title' => 'Post',
            'posts' => $posts,
            'allowedFilterFields' => $this->allowedFilterFields,
            'allowedSortFields' => $allowedSortFields,
            'limits' => $limits,
            'postCategories' => $postCategories
        ]);
    }

    public function edit(Post $post): View
    {
        Gate::authorize(PermissionEnum::UPDATE_POST->value);

        $postCategories = PostCategory::all();

        return view('pages.post.edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'postCategories' => $postCategories,
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize(PermissionEnum::UPDATE_POST->value);

        try {
            $validatedData = $request->validated();

            $post->update($validatedData);

            return redirect()->route('be.post.edit', $post->slug)
                ->with('success', 'Post updated successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());

            return redirect()->route('be.post.edit', $post->slug)
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_POST->value);

        try {
            $post->delete();

            return redirect()
                ->route('be.post.index')
                ->with('success', 'Post deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error("Error deleting post (slug: {$post->slug}): " . $e->getMessage());

            return redirect()
                ->route('be.post.index')
                ->with('error', 'An error occurred while deleting the post.');
        }
    }

    public function massDestroy(Request $request): RedirectResponse
    {
        Gate::authorize(PermissionEnum::DELETE_POST->value);

        try {
            $postSlugArray = explode(',', $request->input('slugs', ''));

            if (!empty($postSlugArray)) {
                Post::whereIn('slug', $postSlugArray)->delete();
            }

            return redirect()
                ->route('be.post.index')
                ->with('success', 'Posts deleted successfully.');
        } catch (AuthorizationException $authorizationException) {
            Log::error($authorizationException->getMessage());

            abort(403, 'This action is unauthorized.');
        } catch (\Exception $e) {
            Log::error('Error deleting posts: ' . $e->getMessage());

            return redirect()
                ->route('be.post.index')
                ->with('error', 'An error occurred while deleting the posts.');
        }
    }

    public function generateSlug(Request $request)
    {
        $title = $request->query('title');
        $slug = Str::slug($title);
        return response()->json(['slug' => $slug]);
    }
}
