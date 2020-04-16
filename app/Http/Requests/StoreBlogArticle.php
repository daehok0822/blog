<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogArticle extends FormRequest
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
            'title' => 'required|max:30',
            'description' => 'required|max:1000',
            'category_id' => 'required'
        ];
    }
    public function messages()
    {


        return [
            'title.required' => '제목이 필요합니다',
            'description.required'  => '본문이 필요합니다',
            'category.required' => '카테고리가 필요합니다',

            'title.max:30' => '제목은 30자를 넘을 수 없습니다',
            'description.max:1000' => '본문은 1000자를 넘을 수 없습니다'

        ];
    }
}
