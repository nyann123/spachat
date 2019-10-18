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

Route::group(['prefix' => 'ajax' , 'namespace' => 'Ajax'] , function () {
    Route::post('entry', 'UserEntry'); // ユーザー名登録

    Route::get('chat', 'ChatController@index'); // メッセージ一覧を取得
    Route::post('chat', 'ChatController@create'); // チャット登録

    Route::get('room', 'RoomController@index'); //チャットルーム取得
    Route::post('room', 'RoomController@create'); //チャットルーム作成
    Route::post('roomHistry', 'RoomController@histry'); //入室済みチャットルーム取得

    Route::post('enterroom', 'EnterRoom'); //チャットルーム入室処理
    Route::post('isEntering', 'isEntering');  //チャットルーム入室確認
    Route::post('roomlimit', 'CheckRoomLimit');   //チャットルームの制限時間確認
    Route::post('roomauth', 'RoomAuth');   //チャットルームのパスワード認証
});

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');