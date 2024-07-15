<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
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
            'files' => ['required', 'array'],
            'files.*' => ['file', 'mimes:jpeg,jpg,png,gif', 'max:2048'],
            'preset' => ['required'],
        ];
    }

    /**
     * Customize the data returned from the validated method.
     *
     * @param null $key
     * @param null $default
     * @return array
     */
    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();

        // Ensure only the defined fields are included in the validated data
        $fields = ['files'];

        return array_intersect_key($validatedData, array_flip($fields));
    }
}
