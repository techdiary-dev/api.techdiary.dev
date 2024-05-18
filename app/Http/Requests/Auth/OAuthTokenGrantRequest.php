<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OAuthTokenGrantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'grant_type' => ['required', 'string', 'in:authorization_code,refresh_token,password'],
            'refresh_token' => ['nullable', 'string'],
            'authorization_code' => ['nullable', 'string'],
            'password' => ['nullable', 'string'],
            'email' => ['nullable', 'string'],
        ];
    }
}
