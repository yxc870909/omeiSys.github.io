<?php

use Illuminate\Database\Seeder;
use \App\Models\Category\Entity\Category as Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = file_get_contents('json/category.json');
    	$category = json_decode($category);

    	foreach($category as $item) {
    		Category::create([
	    		'type'=>$item->type,
	    		'value'=>$item->value,
	    		'word'=>$item->word,
	    		'order'=>$item->order,
	    		'attribute'=>$item->attribute
    		]);
    	}
    }
}
