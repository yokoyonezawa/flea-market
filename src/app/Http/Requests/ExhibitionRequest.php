<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string',
            'detail' => 'required|string',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像は必須です。',
            'image.image' => '画像ファイルをアップロードしてください。',
            'image.mimes' => '画像は jpeg, png, jpg, gif のいずれかの形式でアップロードしてください。',
            'image.max' => '画像のサイズは 2MB 以下にしてください。',

            'name.required' => '商品名は必須です。',
            'name.string' => '商品名は文字で入力してください。',

            'detail.required' => '商品の説明は必須です。',
            'detail.string' => '商品の説明は文字で入力してください。',

            'price.required' => '販売価格は必須です。',
            'price.numeric' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は 1 以上にしてください。',

            'category_id.required' => 'カテゴリを選択してください。',
            'category_id.exists' => '選択されたカテゴリが存在しません。',

            'condition_id.required' => '商品の状態を選択してください。',
            'condition_id.exists' => '選択された商品の状態が存在しません。',
        ];
    }
}
