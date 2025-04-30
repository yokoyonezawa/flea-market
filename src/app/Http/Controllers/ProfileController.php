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
        $profile = Auth::user()->profile ?? new Profile();
        return view('mypage.profile', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'post_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'building_name' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::delete($profile->image);

            }
            $path = $request->file('image')->store('profiles', 'public');
            $profile->image = $path;
        }

        $profile->fill($request->only('post_code', 'address', 'building_name'));
        $profile->save();

        if ($user->is_first_login) {
            $user->update(['is_first_login' => false]);
        }

        return redirect()->route('index')->with('success', 'プロフィールを更新しました。');
    }

        public function editAddress()
        {
            $profile = Auth::user()->profile ?? new Profile();
            return view('edit_address', compact('profile'));
        }


    public function updateAddress(AddressRequest $request)
    {

        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);


        if ($request->hasFile('image')) {
            if ($profile->image) {
                Storage::delete('public/' . $profile->image);
            }

            $path = $request->file('image')->store('profiles', 'public');
            $profile->image = $path;
        }

        $profile->fill($request->validated());
        $profile->save();

        return redirect($request->input('return_url', route('mypage')))->with('success', '住所が更新されました。');
    }

    public function showProfile($id)
    {
        $user = User::findOrFail($id);
        return view('mypage.profile', compact('user'));
    }

}
