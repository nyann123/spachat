<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::namespace('ajax')->group(function () {
    Route::post('ajax/entry', 'UserEntry'); // ユーザー名登録

    Route::get('ajax/chat', 'ChatController@index'); // メッセージ一覧を取得
    Route::post('ajax/chat', 'ChatController@create'); // チャット登録

    Route::get('ajax/room', 'RoomController@index'); //チャットルーム取得
    Route::post('ajax/room', 'RoomController@create'); //チャットルーム作成
    Route::post('ajax/roomHistry', 'RoomController@histry'); //入室済みチャットルーム取得

    Route::post('ajax/enterroom', 'EnterRoom'); //チャットルーム入室処理
    Route::post('ajax/isEntering', 'isEntering');  //チャットルーム入室確認
    Route::post('ajax/roomlimit', 'CheckRoomLimit');   //チャットルームの制限時間確認
    Route::post('ajax/roomauth', 'RoomAuth');   //チャットルームのパスワード認証
});

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');