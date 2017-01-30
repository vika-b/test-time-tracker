<?php

use Illuminate\Database\Seeder;

class RecTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('rec_time')->insert([
            'user_id' => 2,
            'start_time' => '2016-06-21T18:56:48Z',
            'end_time' => '2016-06-21T20:33:10Z',
            'task_title' => 'Initial project setup continue',
        ]);
    }
}
