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
        for($i = 3 ; $i >= 1 ; $i--) {

            \App\ChatRoom::create([
                'room_name' => 'FreeRoom'.$i,
                'host_user' => 'SpaChat',
                'password' => '',
                'limit_at' => Carbon::now()->addDay(3650),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now() 
            ]);
    
        }
    }
}
