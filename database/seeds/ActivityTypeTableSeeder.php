<?php

use Illuminate\Database\Seeder;
use \App\Models\Activity\Entity\ActivityType as ActivityType; 

class ActivityTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ActivityType::create([
        	'title'=>'青年班',
        	]);
        ActivityType::create([
        	'title'=>'研究班',
        	]);
    }
}
