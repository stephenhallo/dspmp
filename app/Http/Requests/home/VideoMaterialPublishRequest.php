<?php

namespace App\Http\Requests\home;

use Illuminate\Foundation\Http\FormRequest;

class VideoMaterialPublishRequest extends FormRequest
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
            'title' => 'required|max:255',
            'category_id' => 'required|max:255',
            'description' => 'required',
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => '名称不能为空',
            'category_id.required' => '分类不能为空',
            'description.required' => '内容不能为空',
            'url.required' => '视频不能为空',
        ];
    }
}
