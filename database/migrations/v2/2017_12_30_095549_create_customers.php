<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::dropIfExists('customers');

        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
			$table->string('name', 200);
			$table->string('surname', 200)->nullable();
	        $table->string('city', 200)->nullable();
	        $table->string('address', 200)->nullable();
			$table->string('pcode', 10)->nullable(); //Postal code
			$table->string('province', 20)->nullable();
	        $table->string('country', 100)->nullable();
	        $table->string('vat', 20)->nullable();
	        $table->string('pid', 20)->nullable(); //Personal ID - Codice fiscale
	        $table->string('email', 150);
	        $table->string('pec', 150)->nullable();
	        $table->string('phone', 20)->nullable();
	        $table->string('fax', 20)->nullable();
	        $table->string('mobile', 20)->nullable();
	        $table->enum('type', ['private','company','pro']); //Pro = professionist
	        $table->tinyInteger('deleted')->default(0);

	        $table->unique(['user_id', 'email']);

	        $table->foreign("user_id")
		        ->references("id")
		        ->on("users");

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
        Schema::dropIfExists('customers');
    }
}
