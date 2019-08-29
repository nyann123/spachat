<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class isEntering extends Controller
{
    public function __invoke(Request $request)
    {

        $data = \App\User::select('room')->find($request->user_id);

        if( $data->room == $request->room_id ){
            return 1;
        }else{
            return 0;
        }
    }

}
