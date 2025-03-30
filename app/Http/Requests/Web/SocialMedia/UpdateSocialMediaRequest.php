<?php

namespace App\Http\Requests\Web\SocialMedia;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSocialMediaRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:social_media,slug,' . $this->route('socialMedia')->slug . ',slug',
            'url' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
        ];
    }
}
