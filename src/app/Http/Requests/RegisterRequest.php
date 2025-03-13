<?php

namespace App\Http\Requests;

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
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'password' => ['required', 'confirmed', 'min:8', 'max:20' ],
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
            'name.required' => 'お名前を入力してください',
            'name.max' => 'お名前は191字が上限です',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスの形式ではございません',
            'email.max' => 'メールアドレスは191字が上限です',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードと一致しません',
            'password.min' => 'パスワードは最低8文字です',
            'password.max' => 'パスワードは最大20文字です',
        ];
    }
}
