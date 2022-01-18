<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Rules\AllLowerCase;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
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
            'password' => ['required', 'min:3', 'max:50', 'confirmed']
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
