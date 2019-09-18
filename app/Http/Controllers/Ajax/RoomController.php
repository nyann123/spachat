<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class RoomController extends Controller
{
    public function index(){
        
        // 現在日時を取得
        $now = Carbon::now();

        //  制限時間内のチャットルームを取得して返す
        return \App\ChatRoom::where('limit_at', '>', $now)->orderBy('id', 'desc')->get();

    }

    public function histry(Request $request){
        
        //  入室済みのチャットルームを取得
        $EnteredRooms = \App\EnteredRoom::where('user_id', $request->user_id)->get();
        
        if( count($EnteredRooms) ){

            //  チャットルームのidを配列に格納
            foreach ($EnteredRooms as $EnteredRoom){
                $rooms[] = $EnteredRoom->room_id;
            }

            //  チャットルームを取得して返す
            return \App\ChatRoom::whereIn('id', $rooms)
                                ->orderBy('id', 'desc')->get();

        }

    }

    public function create(Request $request){

        //  チャットルームの制限時間
        $limit_time = 24;

        //  パスワードが入力されていればハッシュ化
        if ($request->password){
            $password = Hash::make($request->password);
        }else{
            $password = '';
        }
        
        //  チャットルームを作成
        $data = \App\ChatRoom::create([
            'room_name' => $request->room_name,
            'host_user' => $request->user['name'],
            'password' => $password,
            'limit_at' => Carbon::now()->addHour($limit_time),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now() 
            ]);
        
        //  通知を作成
        \App\Message::create([
            'message' => 'チャットルームを作成しました。
                        　終了時間は'.$data->limit_at.'です。',
            'room_id' => $data->id,
            'user_id' => 0,
            'user_name' => '',
            'isNotification' => 1,
        ]);
        
        //  チャットルームを作成したユーザーを入室させる
        \App\EnteredRoom::create([
            'user_id' => $request->user['id'],
            'room_id' => $data->id,
        ]);

        //  作成したチャットルームのidを返す
        return $data->id;
    }
}
