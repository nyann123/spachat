<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserEntryController extends Controller
{
    public function create(Request $request) { // ユーザー名を登録

        // ref! バリデーション

        $data = $message = \App\User::create([
            'name' => $request->name
        ]);
        
        return $data->id;
    }
}
