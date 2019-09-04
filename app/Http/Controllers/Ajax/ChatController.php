<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\MessageCreated;
use Illuminate\Support\Carbon;

class ChatController extends Controller
{
    public function index(Request $request) {

        // 新着順にメッセージ一覧を取得
        return \App\Message::where('room_id', $request->input('room_id'))->get();
    
    }
    
    public function create(Request $request) { 
        
        // 現在日時を取得
        $now = Carbon::now();

        //  制限時間内であればメッセージ登録処理
        if(\App\ChatRoom::where('id', $request->room_id)->where('limit_at', '>', $now)->exists()){

            // メッセージを登録
            $message = \App\Message::create([
                'message' => $request->message,
                'room_id' => $request->room_id,
                'user_id' => $request->user_id,
                'user_name' => $request->user_name,
            ]);

            //  チャット更新用のイベント
            event(new MessageCreated($message));
            
        }else{

            return 1;

        }

    }

}
