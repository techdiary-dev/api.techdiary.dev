<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArticleReactionRequest extends FormRequest
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
        $reaction = [
            'BOOKMARK',
            'HEART',
            'LIKE',
            'FLYHIGH',
            'UNICORN',
            'MONEY',
            'PARTY',
            'TROPHY',
            'CHEER',
        ];

        return [
            'reaction_type' => ['required', Rule::in($reaction)],
        ];
    }
}
