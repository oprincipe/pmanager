<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactsToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
	        $table->string('city', 200)->nullable();
	        $table->string('prov', 10)->nullable();
	        $table->string('country', 20)->nullable();
	        $table->string('tel', 20)->nullable();
	        $table->string('fax', 20)->nullable();
	        $table->string('email', 150)->nullable();
	        $table->string('pec', 150)->nullable();
	        $table->string('skype', 150)->nullable();
	        $table->string('website', 200)->nullable();
	        $table->string('contactName', 200);
	        $table->string('vatCode', 20)->nullable();
	        $table->string('cfCode', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
	        $table->dropColumn('city');
	        $table->dropColumn('prov');
	        $table->dropColumn('country');
	        $table->dropColumn('tel');
	        $table->dropColumn('fax');
	        $table->dropColumn('email');
	        $table->dropColumn('pec');
	        $table->dropColumn('skype');
	        $table->dropColumn('website');
	        $table->dropColumn('contactName');
	        $table->dropColumn('vatCode');
	        $table->dropColumn('cfCode');
        });
    }
}
