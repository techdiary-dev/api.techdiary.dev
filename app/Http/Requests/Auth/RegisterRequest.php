<?php

namespace App\Http\Requests\Auth;

use App\Rules\AllLowerCase;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:50'],
            'username' => ['required', 'min:3', 'max:50', 'unique:users', new AllLowerCase()],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:3', 'max:50', 'confirmed'],
        ];
    }
}
