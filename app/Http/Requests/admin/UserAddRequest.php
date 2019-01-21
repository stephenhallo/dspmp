<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UserAddRequest extends FormRequest
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
            'username' => 'required|unique:users|max:255',
            'password' => 'required|max:255',
//            'alias' => 'required|max:255',
            'status' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'username.unique' => '用户名已存在',
            'password.required' => '密码不能为空',
//            'alias.required' => '昵称不能为空',
            'status.required' => '状态不能为空',
        ];
    }
}
