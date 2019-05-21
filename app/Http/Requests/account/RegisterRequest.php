<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            //'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'username' => 'unique:users',
            'department_id'=>'required',
            'password' => 'required|min:6',
        ];
    }
    public function messages()
    {
        return[
        'email.unique' => 'Email đã tồn tại trong hệ thống',
        'email.email' => 'Email không đúng định dạng',
        'username.unique' => 'Tên đăng nhập đã tồn tại trong hệ thống',
        'department_id.required'=>'Vui lòng chọn nhóm thành viên',
        //'name.required' => 'vui lòng nhập tên',
        'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
        ];  
    }
}
