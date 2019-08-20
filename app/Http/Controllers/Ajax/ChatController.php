<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\MessageCreated;

class ChatController extends Controller
{
    public function index(Request $request) {// 新着順にメッセージ一覧を取得

        return \App\Message::where('room_id', $request->input('room_id'))->get();
    
    }
    
    public function create(Request $request) { // メッセージを登録
        // ref! バリデーション
        $message = \App\Message::create([
            'message' => $request->message,
            'room_id' => $request->room_id,
            'user_id' => $request->user_id,
            'user_name' => $request->user_name,
        ]);
        event(new MessageCreated($message));

    }

}
