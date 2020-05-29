<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Books\Entity\SubscriptionBooks as SubscriptionBooks;
use \App\Models\Books\Entity\ReceiveBooks as ReceiveBooks;
use \App\Models\Books\Entity\Books as Books;
use \App\Models\Category\Repository\CategoryRepository as CategoryRepository;

class SubscriptionBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i=0; $i<rand(10,15); $i++) {
        	$book = CategoryRepository::getDataByType('books_type');

        	$cat = $book[rand(0,count($book)-1)]['value'];
    		$title = $faker->company;
    		$img = array('img2.jpg','solo3.png')[rand(0,1)];
    		$author = $faker->company;
    		$isbn = str_pad(rand(1,999999999), 9, '0', STR_PAD_LEFT);
    		$lan = 'tran_chinese';
    		$pub_year = rand(1800,2017);
    		$version = rand(1,20);
    		$no = str_pad(rand(1,20), 2, '0', STR_PAD_LEFT);
    		$price = rand(200,5000);


        	SubscriptionBooks::create([
        		'cat'=>$cat,
        		'title'=>$title,
        		'img'=>$img,
        		'author'=>$author,
        		'isbn'=>$isbn,
        		'lan'=>$lan,
        		'pub_year'=>$pub_year,
        		'version'=>$version,
        		'no'=>$no,
        		'price'=>$price,
        		'tid'=>rand(1,10),
        		'count'=>rand(1,50),
        		]);

        	ReceiveBooks::create([
        		'cat'=>$cat,
        		'title'=>$title,
        		'img'=>$img,
        		'author'=>$author,
        		'isbn'=>$isbn,
        		'lan'=>$lan,
        		'pub_year'=>$pub_year,
        		'version'=>$version,
        		'no'=>$no,
        		'price'=>$price,
        		'count'=>rand(1,50),
        		]);

        	Books::create([
        		'type'=>'receive',
        		'cat'=>$cat,
        		'title'=>$title,
        		'img'=>$img,
        		'author'=>$faker->company,
        		'isbn'=>$isbn,
        		'lan'=>$lan,
        		'pub_year'=>$pub_year,
        		'version'=>$version,
        		'no'=>$no,
        		'price'=>$price,
        		'count'=>rand(1,10),
        		'is_borrow'=>'false'
        		]);
        }
    }
}
