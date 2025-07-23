<?php

namespace App\Http\Requests\Web\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cover'             => 'nullable|string|image|mimes:jpg,jpeg,png|max:2048',
            'title'             => 'required|string|max:255',
            'slug'              => 'required|string|max:255|alpha_dash|unique:posts,slug,' . $this->route('post')->id,
            'excerpt'           => 'nullable|string',
            'body'              => 'nullable|string',
            'post_category_id'  => 'nullable|exists:post_categories,id',
            'user_id'           => 'nullable|exists:users,id',
            'published_at'      => 'nullable|date',
            'status'            => 'required|in:draft,published',
            'seo_title'         => 'nullable|string|max:255',
            'seo_description'   => 'nullable|string',
            'seo_keywords'      => 'nullable|string',
        ];
    }
}
