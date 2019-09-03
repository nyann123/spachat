<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ChatRoomTableSeeder extends Seeder

{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i <= 5 ; $i++) {

            \App\ChatRoom::create([
                'room_name' => $i .'番目の部屋',
                'host_user' => $i .'番目のホスト',
                'password' => '',
                'limit_at' => Carbon::now()->addDay(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ]);
    
        }
    }
}
