<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('projects')->delete();

	    $sql = "ALTER TABLE `projects` AUTO_INCREMENT=1";
	    DB::statement($sql);

	    for($i = 0; $i < 10; $i++)
	    {
		    DB::table('projects')->insert(array(
			                                  'name' => 'Project '.$i,
			                                  'description' => 'the description of project '.$i,
			                                  'company_id' => 1,
			                                  'user_id' => 1,
			                                  'days' => 0
		                                  ));
	    }



    }
}
