<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Books\Entity\SubApplication as SubApplication;

class SubApplicationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=0; $i<100; $i++) {
        	SubApplication::create([
        		'sbid'=>rand(5,10),
        		'area'=>'Hsinchu_',
        		'count'=>rand(3,30),
        		]);
        }
    }
}
