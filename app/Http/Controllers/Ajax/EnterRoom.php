<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EnterRoom extends Controller
{
    public function __invoke(Request $request)
    {

        \App\User::where('id', $request->user_id)->update(['room' => $request->room_id]);

    }
}
