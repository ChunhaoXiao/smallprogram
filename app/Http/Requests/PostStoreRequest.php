<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            //'pictures' =>'max:5',
            'gender' => ['required', Rule::in(['男', '女'])],
            'nickname' => ['required','max:20', Rule::unique('posts')->ignore($this->user()->post->id)],
            'bod' => 'required|date',
            'location' => 'required',
            'marriage' => 'required',
            'hobby' => 'nullable|max:20',

        ];  
    }

    public function messages()
    {
        return [
            'content.required' => '个人介绍不能为空',
            'content.min' => '爱情宣言字数不能少于10字',
            'content.max' => '爱情宣言最多500个字',
            'nickname.required' => '昵称不能为空',
            'nickname.max' => '昵称长度最多20个字符',
            'nickname.unique' => '昵称已存在',
            'bod.required' => '出生日期不能为空',
            'location.required' => '请选择所在地',
            'gender.required' => '请选择性别',
            'marriage.required' => '请选择婚姻状况'
            //'pictures.max' => '最多上传5张图片', 
        ];
    }
}
