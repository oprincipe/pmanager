<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	if(!Schema::hasTable('users')) {
		    Schema::create('users', function (Blueprint $table) {
			    $table->increments('id');

			    $table->string('first_name')->nullable();
			    $table->string('middle_name')->nullable();
			    $table->string('last_name')->nullable();
			    $table->string('city')->nullable();
			    $table->integer("role_id")->unisigned()->default(3);

			    $table->string('email')->unique();
			    $table->string('password');
			    $table->rememberToken();
			    $table->timestamps();
		    });
	    }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
