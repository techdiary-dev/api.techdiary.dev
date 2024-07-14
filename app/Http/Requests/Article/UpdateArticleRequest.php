<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateArticleRequest extends FormRequest
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
            'title' => ['nullable', 'max:255'],
            'slug' => ['nullable', 'max:255',  Rule::unique('articles', 'slug')->ignore($this->route('article'))],
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
}
