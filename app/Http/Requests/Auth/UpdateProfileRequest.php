<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['nullable', 'min:6'],
            'username' => ['nullable', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['nullable', Rule::unique('users')->ignore(auth()->id())],
            'education' => ['nullable'],
            'designation' => ['nullable'],
            'website_url' => ['nullable', 'url'],
            'location' => ['nullable'],
            'profilePhoto' => ['nullable', 'url'],
            'social_links' => ['nullable']
        ];
    }
}
