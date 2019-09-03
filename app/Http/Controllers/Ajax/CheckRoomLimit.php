<?php

namespace App\Http\Controllers\ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class CheckRoomLimit extends Controller
{
    public function __invoke(Request $request)
    {   

        //  現在の日時を取得
        $now = Carbon::now();

        if(\App\ChatRoom::where('id', $request->room_id)->where('limit_at', '>', $now)->exists()){
            
            return 0;

        }else{

            return 1;

        }

    }
}
