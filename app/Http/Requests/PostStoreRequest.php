<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
            'content' => 'required|min:10|max:500',
            'pictures' =>'max:5',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => '爱情宣言不能为空',
            'content.min' => '爱情宣言字数不能少于10字',
            'content.max' => '爱情宣言最多500个字',
            'pictures.max' => '最多上传5张图片', 
        ];
    }
}
