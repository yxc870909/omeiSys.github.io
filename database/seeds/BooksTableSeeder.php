<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use \App\Models\Books\Entity\Books as Books;
use \App\Models\Category\Repository\CategoryRepository as CategoryRepository;

class BooksTableSeeder extends Seeder
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
        	$book = CategoryRepository::getDataByType('library_books_type');


        	Books::create([
        		'type'=>'library',
        		'cat'=>$book[rand(0,count($book)-1)]['value'],
                'number'=>rand(1000000,9999999),
                'location'=>$faker->swiftBicNumber,
        		'title'=>$faker->company,
        		'img'=>array('img2.jpg','solo3.png')[rand(0,1)],
        		'author'=>$faker->company,
        		'isbn'=>str_pad(rand(1,999999999), 9, '0', STR_PAD_LEFT),
        		'lan'=>'tran_chinese',
        		'pub_year'=>rand(1800,2017),
        		'version'=>rand(1,20),
        		'no'=>str_pad(rand(1,20), 2, '0', STR_PAD_LEFT),
        		'price'=>rand(200,5000),
        		'tid'=>rand(1,10),
        		'count'=>rand(1,10),
        		'buy_date'=>$faker->date($format = 'Y-m-d', $max = 'now'),
        		'is_borrow'=>array('true','false')[rand(0,1)]
        		]);
        }
    }
}
