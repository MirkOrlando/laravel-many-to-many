<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostRequest extends FormRequest
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
            'title' => ['required', Rule::unique('posts')->ignore($this->post), 'max:150'],
            'cover_img' => 'nullable',
            'content' => 'required',
            'category_id' => ['nullable', 'exists:categories,id'],
            'tags' => ['exists:tags,id'],
            'user_id' => ['exists:users,id'],
        ];
    }
}