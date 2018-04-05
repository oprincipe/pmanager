<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TaskUserAddPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_user', function (Blueprint $table) {
            $table->integer("hours_real")->after("user_id")->default(0);
            $table->integer("hours")->after("hours_real")->default(0);
            $table->decimal("price", 10, 2)->after("hours")->default(0);
            $table->decimal("value", 13, 2)->after("price")->default(0);
            $table->decimal("value_real", 13, 2)->after("value")->default(0);
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->decimal("price", 10, 2)->after("hours")->default(0)->change();
            $table->decimal("value", 13, 2)->after("price")->default(0)->change();
            $table->decimal("value_real", 13, 2)->after("value")->default(0)->change();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_user', function (Blueprint $table) {
            $table->dropColumn("hours_real", 8, 2);
            $table->dropColumn("hours", 10, 2);
            $table->dropColumn("price", 8, 2);
            $table->dropColumn("value", 10, 2);
            $table->dropColumn("value_real", 10, 2);
        });
    }
}
