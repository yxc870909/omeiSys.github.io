<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Activity\Entity\Activity as Activity;
use \App\Models\Activity\Entity\ActivityUser as ActivityUser;

class ActivityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i=0; $i < rand(10,15); $i++) {
        	Activity::create([
        		'type'=>array('青年班','研究班')[rand(0,1)],
                'tid'=>rand(1,10),
        		'preside'=>json_encode(array(rand(1,100),rand(1,100))),
        		'course_title'=>json_encode(array($faker->sentence,$faker->sentence)),
        		'course_lecturer'=>json_encode(array(rand(1,100),rand(1,100))),
        		'song_title'=>json_encode(array($faker->sentence,$faker->sentence)),
        		'song_lecturer'=>json_encode(array(rand(1,100),rand(1,100))),
        		'add_date'=>date('Y-m-d'),
        		'last_edit'=>rand(1,10),
        		]);

            for($k=0; $k<rand(5,50); $k++) {
                ActivityUser::create([
                    'aid'=>$i+1,
                    'upid'=>rand(30,70),
                    'name'=>$faker->firstNameMale.$faker->lastName,
                    'gender'=>array('male','female')[rand(0,1)],
                    'year'=>rand(30,70),
                    'temple'=>rand(1,10),
                    'addr'=>$faker->address,
                    'inDB'=>rand(1,2)==1 ? 'yes' : 'no',
                    ]);    
            }
        }
    }
}
