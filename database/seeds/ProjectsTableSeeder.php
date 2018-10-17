<?php

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $project = new Project;

        for($i = 0; $i < 1000; $i++) {
            $randStrTime = mt_rand(1152005681,1262055681);
            $randDay = mt_rand(1, 10);
            $date = strtotime('+'.$randDay.' days', $randStrTime);

            $textRandom = str_random(mt_rand(1, 15));
            for($x = 0; $x < 70; $x++) {
                $textRandom .= ' '.str_random(mt_rand(1, 15));
            }

            DB::table('projects')->insert([
                'title' => str_random(10),
                'descrription' => $textRandom,
                'organization' => str_random(mt_rand(4, 10)),
                'start' => date('Y-m-d', $randStrTime),
                'end' => date("Y-m-d", $date),
                'role' => array_rand(['admin' => 'admin', 'user' => 'user'], 1),
                'link' => 'http://'.str_random(10).'.com',
                'type' =>  array_rand($project->getTypes(), 1),
            ]);
        }
    }
}
