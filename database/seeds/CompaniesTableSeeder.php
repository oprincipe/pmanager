<?php

use Illuminate\Database\Seeder;
use App\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('companies')->delete();

	    $sql = "ALTER TABLE `companies` AUTO_INCREMENT=1";
	    DB::statement($sql);

	    DB::table('companies')->insert(array(
		                                   'name' => 'Company test 10',
		                                   'description' => 'the description of first company',
		                                   'user_id' => 1
	                                   ));


	    DB::table('companies')->insert(array(
		                                   'name' => 'Company test 2',
		                                   'description' => 'the description of second company',
		                                   'user_id' => 1
	                                   ));
	}
}
