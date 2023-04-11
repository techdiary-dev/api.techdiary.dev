<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CommentStoreRequest extends FormRequest
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
        $models = [
            'ARTICLE',
        ];

        return [
            'model_name' => ['required', Rule::in($models)],
            'model_id' => ['required'],
            'body' => ['required'],
            'parent_id' => ['nullable'],
        ];
    }
}
