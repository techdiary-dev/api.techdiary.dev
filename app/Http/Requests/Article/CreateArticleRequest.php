<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => ['required', 'max:255'],
            'slug' => ['nullable', 'max:255', 'unique:articles,slug'],
            'excerpt' => ['nullable', 'min:5', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'seriesName' => ['nullable'],
            'thumbnail.key' => ['nullable', 'max:255'],
            'thumbnail.url' => ['nullable', 'url', 'max:255'],
            'body' => ['nullable'],
            'tags' => ['nullable', 'array'],

            'seo.og_image' => ['nullable', 'url'],
            'seo.seo_title' => ['nullable', 'string', 'max:255'],
            'seo.seo_description' => ['nullable', 'string', 'max:255'],
            'seo.canonical_url' => ['nullable', 'url', 'max:255'],
            'settings.disabled_comments' => ['nullable', 'boolean', 'max:255'],
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
