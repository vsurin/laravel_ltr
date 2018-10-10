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
        for($i=0; $i<1000; $i++) {
            DB::table('projects')->insert([
                'title' => str_random(10),
                'descrription' => str_random(100),
                'organization' => str_random(10),
                'start' => '2018-10-09 14:13:30',
                'end' => '2018-10-09 14:13:30',
                'role' => str_random(10),
                'links' => str_random(10),
                'type_id' => 1,
            ]);
        }
    }
}
