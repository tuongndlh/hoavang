<?php

namespace App\Http\Requests\media\message_setting;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'point_from'    => 'numeric',
            'point_to' => 'numeric',
            'promotion_id'=>'required',
            'message_id' => 'required',
        ];
    }
    public function messages()
    {
        return[
        'point_from.numeric' => 'Vui lòng nhập số',
        'point_to.numeric' => 'Vui lòng nhập số',
        'promotion_id.required' => 'Vui lòng chọn chương trình khuyến mãi',
        'message_id.required'=>'Vui lòng chọn nội dung tin nhắn',
        ];  
    }
}
