<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class RoomController extends Controller
{
    public function index(){

        return \App\ChatRoom::orderBy('id', 'desc')->get();

    }

    public function create(Request $request){

        if ($request->password){
            $password = Hash::make($request->password);
        }else{
            $password = '';
        }
        
        $data = \App\ChatRoom::create([
            'room_name' => $request->room_name,
            'host_user' => $request->host_user,
            'password' => $password,
            ]);
        
        return $data->id;
    }
}
