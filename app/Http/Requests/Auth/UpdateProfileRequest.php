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
            'name' => ['nullable', 'min:6', 'max:255'],
            'username' => ['nullable', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'email' => ['nullable', 'max:255', Rule::unique('users')->ignore(auth()->id())],
            'education' => ['nullable','max:255'],
            'designation' => ['nullable', 'max:255'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'profilePhoto' => ['nullable', 'url', 'max:255'],
            'profile_readme' => ['nullable'],
            'social_links' => ['nullable'],
        ];
    }
}
