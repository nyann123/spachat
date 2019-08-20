<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i <= 100 ; $i++) {

            DB::table('messages')->insert([
                'message' => $i .'番目のテキスト',
                'room_id' => 1,
                'user_id' => $i,
                'user_name' => $i . 'さん',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

        }
    }
}
