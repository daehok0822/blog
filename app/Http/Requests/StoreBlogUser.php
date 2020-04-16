<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogUser extends FormRequest
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
            'name' => 'required|max:15',
            'email' => 'required',
            'password' => 'required|max:15'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '이름이 필요합니다',
            'email.required'  => '이메일이 필요합니다',
            'password.required' => '비밀번호가 필요합니다',
            'name.max:15' => '이름은 15자를 넘을 수 없습니다',
            'password.max:15' => '비번은 15자를 넘을 수 없습니다'

        ];
    }
}
