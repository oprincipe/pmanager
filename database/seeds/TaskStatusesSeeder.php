<?php

use Illuminate\Database\Seeder;

class TaskStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('task_statuses')->insert(['name' => 'stand by']);
	    DB::table('task_statuses')->insert(['name' => 'waiting']);
	    DB::table('task_statuses')->insert(['name' => 'working']);
	    DB::table('task_statuses')->insert(['name' => 'closed']);
    }
}
