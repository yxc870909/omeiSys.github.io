<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Activity\Entity\CenterActivity as CenterActivity;
use \App\Models\Activity\Entity\CenterActivityUser as CenterActivityUser;

class CenterActivityTableSeeder extends Seeder
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
        	CenterActivity::create([
        		'type'=>array('明德班','新民班','至善班','宣德班','弘德班','乾德班','坤德班','長青班')[rand(0,7)],
        		'add_date'=>date('Y-m-d'),
        		'last_edit'=>rand(1,10),
        		]);

            for($k=0; $k<rand(5,50); $k++) {
                CenterActivityUser::create([
                    'caid'=>$i+1,
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
