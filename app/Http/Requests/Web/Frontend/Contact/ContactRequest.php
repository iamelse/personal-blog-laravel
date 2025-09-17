<?php

namespace App\Http\Requests\Web\Frontend\Contact;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email:rfc,dns',
            'message'              => 'required|string|min:3',
            'g-recaptcha-response' => 'required',
        ];
    }
}
