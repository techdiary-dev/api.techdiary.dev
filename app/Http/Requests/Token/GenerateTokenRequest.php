<?php

namespace App\Http\Requests\Token;

use Illuminate\Foundation\Http\FormRequest;

class GenerateTokenRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "oauth_uid" => ['required'],
            "oauth_provider" => ['required', 'in:github,google'],
            "email" => ['required'],
            "name" => ['required'],
            "image" => ['nullable'],
            'secret' => ['required']
        ];
    }
}
