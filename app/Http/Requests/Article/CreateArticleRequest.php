<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateArticleRequest extends FormRequest
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
            'title' => ['required', 'min:5'],
            'excerpt' => ['nullable', 'min:5'],
            'isPublished' => ['nullable', 'boolean'],
            'seriesName' => ['nullable', 'min:5'],
            'thumbnail' => ['nullable', 'url'],
            'body' => ['required', 'array'],
            'tags' => ['array'],
        ];
    }

//    public function messages()
//    {
//        return [
//            'title.required' => 'ডায়েরির শিরোনাম দেননি। ',
//            'body.required'  => 'A message is required',
//        ];
//    }
}
