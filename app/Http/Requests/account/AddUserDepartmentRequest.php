<?php

namespace App\Http\Requests\Account;

use Illuminate\Foundation\Http\FormRequest;

class AddUserDepartmentRequest extends FormRequest
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
            'check'=>'required',
        ];
    }
    public function messages()
    {
        return[
        
        'check.required'=>'Vui lòng chọn thành viên',
        //'name.required' => 'vui lòng nhập tên',
        //'password.min' => 'Mật khẩu tối thiểu 6 ký tự',
        ];  
    }
}
