<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaskStatusToTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function(Blueprint $table) {
        	$table->addColumn('integer', 'status_id')->unsigned()->nullable();
	        $table->foreign('status_id')->references('id')->on('task_statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table('tasks_status_id_foreign', function(Blueprint $table) {
		    $table->dropColumn('status_id');
		    $table->dropForeign('status_id');
	    });
    }
}
