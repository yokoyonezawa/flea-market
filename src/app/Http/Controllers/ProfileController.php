<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AddressRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = Auth::user()->profile ?? new Profile(); // プロフィールがなければ新規作成
        return view('mypage.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'post_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // 画像のバリデーション
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // 画像のアップロード処理
        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::delete($profile->image);

            }
            $path = $request->file('image')->store('profiles', 'public');
            $profile->image = $path;
        }

        // データの保存
        $profile->fill($request->only('post_code', 'address', 'building_name'));
        $profile->save();

        // プロフィール登録後に is_first_login を false にする
        if ($user->is_first_login) {
            $user->update(['is_first_login' => false]);
        }

        return redirect()->route('index')->with('success', 'プロフィールを更新しました。');
    }

    public function editAddress()
    {
        $profile = Auth::user()->profile ?? new Profile();
        return view('mypage.edit_address', compact('profile'));
    }

    public function updateAddress(AddressRequest $request)
    {

        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        // 画像のアップロード処理
        if ($request->hasFile('image')) {
            // 既存の画像を削除
            if ($profile->image) {
                Storage::delete('public/' . $profile->image);
            }

            // 新しい画像を保存
            $path = $request->file('image')->store('profiles', 'public');
            $profile->image = $path;
        }

        // データの保存
        $profile->fill($request->validated());
        $profile->save();

        return redirect($request->input('return_url', route('mypage')))->with('success', '住所が更新されました。');
    }

}
