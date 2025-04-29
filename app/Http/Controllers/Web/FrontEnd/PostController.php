<?php

namespace App\Http\Controllers\Web\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $postCategories = PostCategory::all();
        $allowedFilterFields = ['title', 'slug', 'excerpt', 'body'];
        $posts = Post::with('category')->search(
            keyword: $request->keyword,
            columns: $allowedFilterFields,
        )->sort(
            sort_by: $request->sort_by ?? 'published_at',
            sort_order: $request->sort_order ?? 'DESC'
        )->when($request->category, fn($query, $category) =>
            $query->whereHas('category', fn($q) => $q->where('slug', $category))
        )->paginate($request->query('limit') ?? 6);

        return view('pages.frontend.post.index', [
            'title' => 'All Post',
            'postCategories' => $postCategories,
            'posts' => $posts,
        ]);
    }

    public function show(Post $post)
    {
        return view('pages.frontend.post.show', [
            'title' => $post->title,
            'post' => $post,
        ]);
    }
}
