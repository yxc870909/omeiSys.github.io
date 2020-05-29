<?php

use Illuminate\Database\Seeder;
use \App\Models\Activity\Entity\CenterActivityType as CenterActivityType; 

class CenterActivityTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CenterActivityType::create(['title'=>'明德班',]);
        CenterActivityType::create(['title'=>'新民班',]);
        CenterActivityType::create(['title'=>'至善班',]);
        CenterActivityType::create(['title'=>'宣德班',]);
        CenterActivityType::create(['title'=>'弘德班',]);
        CenterActivityType::create(['title'=>'乾德班',]);
        CenterActivityType::create(['title'=>'坤德班',]);
        CenterActivityType::create(['title'=>'長青班']);
    }
}
