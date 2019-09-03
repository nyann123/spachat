<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class isEntering extends Controller
{
    public function __invoke(Request $request)
    {

        $exists = \App\EnteredRoom::where('room_id', $request->room_id)
                                    ->where('user_id', $request->user_id)
                                    ->exists();

        if($exists){
            return 1;
        }else{
            return 0;
        }

    }

}
