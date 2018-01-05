<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::dropIfExists('customer_projects');
	    Schema::dropIfExists('project_user');

        Schema::create('customer_projects', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('project_id')->unsigned();
	        $table->integer('customer_id')->unsigned();

	        $table->foreign('project_id')->references('id')->on('projects');
	        $table->foreign('customer_id')->references('id')->on('customers');

	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists('customer_projects');
    }
}
