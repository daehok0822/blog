<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogComment extends FormRequest
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
            'nickname' => 'required|max:15',
            'password' => 'required',
            'description' => 'required|max:200'
        ];
    }
    public function messages()
    {
        return [
            'nickname.required' => '닉네임이 필요합니다',
            'description.required'  => '내용이 필요합니다',
            'password.required' => '비밀번호가 필요합니다',

            'nickname.max:15' => '닉네임은 15자를 넘을 수 없습니다',
            'description.max:200' => '내용은 200자를 넘을 수 없습니다'

        ];
    }
}
