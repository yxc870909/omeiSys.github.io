<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Temple\Entity\Temple as Temple;

class TempleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker::create();
    	$type = array('family','public');

    	for($i=0 ; $i<10; $i++) {
    		Temple::create([
    		'name'=>$faker->company,
    		'type'=>$type[rand(0,1)],
    		'area'=>'Hsinchu_',
    		'addr'=>$faker->address,
    		'upid'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
    		'bookstore'=>'true'
    		]);
    	}
    	
    }
}
