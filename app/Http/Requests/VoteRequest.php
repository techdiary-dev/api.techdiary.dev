<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoteRequest extends FormRequest
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
            'COMMENT',
        ];

        return [
            'model_name' => ['required', Rule::in($models)],
            'model_id' => ['required'],
            'vote' => ['required', Rule::in(['UP_VOTE', 'DOWN_VOTE'])],
        ];
    }
}
