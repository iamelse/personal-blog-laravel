<?php

namespace App\Http\Requests\Web\Home;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAboutRequest extends FormRequest
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
            'content.title' => 'required|string|max:255',
            'content.image' => 'nullable',
            'content.description' => 'required|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'content.title' => 'title',
            'content.image' => 'image',
            'content.description' => 'description'
        ];
    }
}
