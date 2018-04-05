<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaskAddValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
	        $table->decimal("value", 10, 2)->after("price");
	        $table->decimal("value_real", 10, 2)->after("value");
        });

	    $sql = "UPDATE tasks SET `hours_real` = 0 where hours_real is null";
	    DB::connection()->getPdo()->exec($sql);
	    $sql = "UPDATE tasks SET `value` = price * hours";
	    DB::connection()->getPdo()->exec($sql);
	    $sql = "UPDATE tasks SET `value_real` = price * hours_real";
	    DB::connection()->getPdo()->exec($sql);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn("value");
        });
    }
}
