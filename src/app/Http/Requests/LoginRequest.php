<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => ['required','email','max:191'],
            'password' => ['required','min:8','max:20'],
        ];
    }
    /**
     * Error message.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式ではございません',
            'password.required' => 'パスワードを入力してください',
            'password.min' => 'パスワードは最低8文字です',
            'password.max' => 'パスワードは最大20文字です',
        ];
    }
}
