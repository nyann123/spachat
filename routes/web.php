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

Route::post('ajax/entry', 'Ajax\UserEntryController@create'); // ユーザー名登録

Route::get('ajax/chat', 'Ajax\ChatController@index'); // メッセージ一覧を取得
Route::post('ajax/chat', 'Ajax\ChatController@create'); // チャット登録

Route::get('ajax/room', 'Ajax\RoomController@index'); //チャットルーム取得
Route::post('ajax/room', 'Ajax\RoomController@create'); //チャットルーム作成

Route::post('ajax/roomauth', 'Ajax\RoomAuth');   //チャットルームのパスワード認証

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');