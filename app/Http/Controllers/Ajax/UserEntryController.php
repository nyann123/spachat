<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserEntryController extends Controller
{
    public function create(Request $request) { // ユーザー名を登録

        $data =  \App\User::create([
            'name' => $request->name
        ]);
        
        return $data->id;
    }
}
