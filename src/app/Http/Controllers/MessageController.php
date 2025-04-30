<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    public function store(MessageRequest $request, $purchaseId)
    {
        $message = new Message();
        $message->purchase_id = $purchaseId;
        $message->user_id = Auth::id();
        $message->content = $request->content;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('message_images', 'public');
            $message->image_path = $path;
        }

        $message->save();

        return back()->with('success', 'メッセージを送信しました');
    }


    public function edit(Message $message)
    {
        return view('messages.edit', compact('message'));
    }


    public function update(MessageRequest $request, Message $message)
    {
        $message->content = $request->content;

        if ($request->hasFile('image')) {
            if ($message->image_path) {
                Storage::delete($message->image_path);
            }


            $path = $request->file('image')->store('message_images', 'public');
            $message->image_path = $path;
        }

        $message->save();

        return redirect()->route('purchase.trading', $message->purchase_id)->with('success', 'メッセージを更新しました！');
    }


    public function destroy(Message $message)
    {

        if ($message->image_path) {
            Storage::delete($message->image_path);
        }

        $message->delete();

        return back()->with('success', 'メッセージを削除しました！');
    }

}
