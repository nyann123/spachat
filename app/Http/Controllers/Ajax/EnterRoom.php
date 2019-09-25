<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnterRoom extends Controller
{
    public function __invoke(Request $request)
    {
        
        //  ユーザーを取得
        $user = \App\User::find($request->user_id);

        //  入室済みか確認
        $data = \App\EnteredRoom::where('user_id' , $request->user_id)
                                ->where('room_id' , $request->room_id)
                                ->exists();
                                

        if(!$data){

            //  ユーザーを入室させる
            \App\EnteredRoom::create([
                'user_id' => $user->id,
                'room_id' => $request->room_id,
            ]);
            
            //  通知を作成
            \App\Message::create([
                'message' => $user->name.'が参加しました。',
                'room_id' => $request->room_id,
                'user_id' => 0,
                'user_name' => '',
                'isNotification' => 1,
            ]);
                
        }

    }
}
