<?php

namespace App\Http\Requests\Web\Skill;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
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
            'name' => 'required|max:255|unique:skills,name,' . $this->route('skill')->name . ',name',
            'slug' => 'required|max:255|unique:skills,slug,' . $this->route('skill')->slug . ',slug',
            'icon_class' => 'required|max:255'
        ];        
    }
}
