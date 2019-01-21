<?php

namespace App\Http\Requests\home;

use Illuminate\Foundation\Http\FormRequest;

class ArtistJobPublishRequest extends FormRequest
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
            'artister_id' => 'required|max:255',
            'completed_at' => 'required|max:255',
        ];
    }

    public function messages()
    {
        return [
            'artister_id.required' => '请设置执行者',
            'completed_at.required' => '请设置截止时间',
        ];
    }
}
