<?php

use Illuminate\Database\Seeder;

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
                'password' => ''
            ]);
    
        }
    }
}
