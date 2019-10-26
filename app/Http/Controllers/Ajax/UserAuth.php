<?php

namespace App\Http\Controllers\Ajax;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserAuth extends Controller
{
    public function __invoke(Request $request)
    {

        //　必須パラメータが登録されているか確認
        $check_param = ['id','name','taken'];
        $exist = true;
        foreach ($check_param as $param){
            
            if( !isset($request->user[$param]) ){
                
                $exist = false;

            }
            
        }

        if( $exist ){

            // ユーザーを取得
            $user = \App\User::find($request->user['id']);
            
            // ユーザー認証
            if( $request->user['taken'] === $user->taken){
                
                return 'sucsess';
                
            }
            
        }

    }
}
