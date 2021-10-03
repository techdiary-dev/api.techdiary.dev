<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

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
            'slug' => ['nullable', 'max:255'],
            'excerpt' => ['nullable', 'min:5', 'max:255'],
            'isPublished' => ['nullable', 'boolean'],
            'seriesName' => ['nullable', 'min:5', 'max:255'],
            'thumbnail' => ['nullable', 'url', 'max:255'],
            'body' => ['nullable'],
            'tags' => ['nullable', 'array'],

            "seo.og_image" => ['nullable', 'url'],
            "seo.seo_title" => ['nullable', 'string', 'max:255'],
            "seo.seo_description" => ['nullable', 'string', 'max:255'],
            "seo.canonical_url" => ['nullable', 'url', 'max:255'],
            "settings.disabled_comments" => ['nullable', 'boolean', 'max:255'],
        ];
    }
}
