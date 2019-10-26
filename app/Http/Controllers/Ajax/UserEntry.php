<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserEntry extends Controller
{
    public function __invoke(Request $request)
    {
        
        $taken = uniqid(rand());

        // ユーザー名を登録
        $data =  \App\User::updateOrCreate([
            'id' => $request->user_id
        ],[
            'name' => $request->user_name,
            'taken' => $taken,
        ]);
        

        return $data;
    }
}
