<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
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
            'content' => 'required|max:200',
            'to' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '内容不能为空',
            'content.max' => '内容最多200个字',
            'to.required' => '收件人不存在',
            'to.exists' => '收件人不存在',
        ];
    }
}
