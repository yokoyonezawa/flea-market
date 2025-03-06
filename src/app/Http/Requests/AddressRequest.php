<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'post_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:100',
            'building_name' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        return [
            'post_code.max' => '郵便番号は10文字以内で入力してください。',
            'address.max' => '住所は100文字以内で入力してください。',
            'building_name.max' => '建物名は100文字以内で入力してください。',
        ];
    }
}
