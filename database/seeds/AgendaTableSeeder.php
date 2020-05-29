<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Agenda\Entity\Agenda as Agenda;
use \App\Models\Agenda\Entity\AgendaUser as AgendaUser;

class AgendaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create();

        $cls_count = rand(50,100);
        $member_count = rand(5,50);
        for($i=0; $i<$cls_count; $i++) {
        	Agenda::create([
                'tid'=>rand(1,10),
                'type'=>array('one','recls','three')[rand(0,2)],
        		'Dianchuanshi'=>rand(1,5),
        		'Dianchuanshi2'=>rand(1,5),
                'Introducer'=>rand(1,100),
                'Guarantor'=>rand(1,100),
        		'upper'=>rand(1,5),
        		'lowwer'=>rand(1,5),
        		'action'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'support'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'counseling'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'write'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'towel'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'music'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'service1'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'traffic'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'affairs'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'cooker'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'uplow'=>rand(1,100),
        		'sambo'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'add'=>rand(1,100),
        		'aegis'=>rand(1,100),
        		'flower'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'accounting'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'course_title'=>json_encode(array($faker->sentence,$faker->sentence,$faker->sentence)),
        		'course_lecturer'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
        		'song_title'=>json_encode(array($faker->sentence,$faker->sentence,$faker->sentence)),
        		'song_lecturer'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'add_date'=>(date('Y')-rand(0,3)).'-'.rand(1,12).'-'.rand(1,28),
        		]);

            for($k=0; $k<rand(5,50); $k++) {
                AgendaUser::create([
                    'aid'=>$i+1,
                    'upid'=>rand(1,100),
                    'name'=>$faker->firstNameMale.$faker->lastName,
                    'gender'=>'',
                    'year'=>rand(30,70),
                    'temple'=>rand(1,10),
                    'addr'=>$faker->address,
                    'inDB'=>rand(1,2)==1 ? 'yes' : 'no',
                    'app'=>rand(1,2)==1 ? 'yes' : 'no',
                    ]);    
            }        	
        }
    }
}
