<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnterRoom extends Controller
{
    public function __invoke(Request $request)
    {

        //  データが存在しなければ新規登録
        \App\EnteredRoom::firstOrCreate([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
        ],[
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
        ]);


    }
}
