<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Books\Entity\BorrowBooks as BorrowBooks;

class BorrowBooksSeeder extends Seeder
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
        	$borrow_date = $faker->date($format = 'Y-m-d', $max = 'now');
        	$return_date = date('Y-m-d', strtotime('+2 month', strtotime($borrow_date)));

        	BorrowBooks::create([
        		'bbid'=>rand(5,10),
        		'upid'=>rand(1,100),
        		'count'=>rand(3,10),
        		'borrow_date'=>$borrow_date,
        		'return_date'=>$return_date,
        		]);
        }
    }
}
