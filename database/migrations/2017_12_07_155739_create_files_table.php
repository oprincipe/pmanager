<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    if(!Schema::hasTable('files')) {

		    Schema::dropIfExists('files');

	    	Schema::create('files', function (Blueprint $table) {
			    $table->increments('id');
			    $table->string('filename', 255);
			    $table->string('ext', 5);
			    $table->string('type', 100);
			    $table->integer('size', 10);
			    $table->string('filepath', 255);
			    $table->integer('user_id')->unsigned();

			    //Polimorphic relationship
			    $table->integer('uploadable_id')->unsigned();
			    $table->string('uploadable_type');

			    $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('files');
    }
}
