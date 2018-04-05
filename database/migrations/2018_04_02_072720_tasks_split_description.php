<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TasksSplitDescription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists("task_descriptions");

        Schema::disableForeignKeyConstraints();
        Schema::create('task_descriptions', function (Blueprint $table) {
            $table->unsignedInteger('task_id');
            $table->longText('description')->nullable();

            $table->index('task_id');
            $table->primary("task_id");
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete("cascade");

        });

        $sql = "INSERT INTO task_descriptions
                (
                SELECT id as task_id, description FROM tasks
                )";
        DB::connection()->getPdo()->exec($sql);

        Schema::enableForeignKeyConstraints();

        //Drop column description for tasks
        Schema::table("tasks", function (Blueprint $table) {
           $table->dropColumn("description");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_descriptions');
    }
}
