<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class UserEditRequest extends FormRequest
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
        $id = $this->route('id');   //更新时排除自身记录
        return [
            'username' => 'required|max:255|unique:users,username,'.$id,
//            'alias' => 'required|max:255',
            'email' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '用户名不能为空',
            'alias.required' => '昵称不能为空',
            'email.required' => '邮箱不能为空',
            'username.unique' => '用户名唯一',
        ];
    }
}
