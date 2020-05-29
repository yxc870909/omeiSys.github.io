<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\User\Entity\User;
use \App\Models\Regist\Entity\Regist as Regist;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        User::create([
            'type'=>'admin',
            'status'=>'active',
            'uid'=>'admin',
            'password'=>Hash::make('admin'),
            'email'=>'admin',
            'gender'=>array('male','female')[rand(0,1)],
            'edu'=>array('PS','JS','SS')[rand(0,2)],
            'skill'=>array('Woodworking','Hydropower','paint')[rand(0,2)],
            'regist_id'=>rand(1,100),
        ]);

        for($i=0; $i<100; $i++) {
        	$email = $faker->email;

        	User::create([
                'type'=>'General',
                'uid'=>$email,
                'password'=>Hash::make('12345'),
                'first_name'=>$faker->firstNameMale,
                'last_name'=>$faker->lastName,
                'email'=>$email,
                'gender'=>array('male','female')[rand(0,1)],
                'addr'=>$faker->address,
                'Dianchuanshi'=>rand(1,100),
                'Introducer'=>rand(1,100),
                'Guarantor'=>rand(1,100),
                'edu'=>array('PS','JS','SS')[rand(0,2)],
                'skill'=>array('Woodworking','Hydropower','paint')[rand(0,2)],
                'area'=>'Hsinchu_',
                'regist_id'=>rand(1,100),
                //'register_date'=>(date('Y')-rand(0,3)).'-'.rand(1,12).'-'.rand(1,28)
        	]);

            Regist::create([
                'tid'=>rand(1,10),
                'upper'=>rand(1,100),
                'lowwer'=>rand(1,100),
                'action'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),     
                'support'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'service1'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'service2'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'towel'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'traffic'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'cooker'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'sambo'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'Introduction'=>json_encode(array(rand(1,100),rand(1,100),rand(1,100))),
                'preside'=>json_encode(array(rand(1,100),rand(1,100))),
                'add_date'=>(date('Y')-rand(0,3)).'-'.rand(1,12).'-'.rand(1,28)
            ]);
        }
    }
}
