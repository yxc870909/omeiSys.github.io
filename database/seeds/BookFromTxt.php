<?php

use Illuminate\Database\Seeder;
use \App\Models\Entity\Books as Books;
use \App\Models\Entity\Category as Category;

class BookFromTxt extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('txt/book.txt', 'r');

        $i = 0;
        while(!feof($file)) {

        	if($i == 0) fgets($file);
        	else {
        		$rowData = explode('	', fgets($file));

        		if(is_array($rowData) && !empty($rowData)) {

        			foreach($rowData as &$item)
						trim($item);
					unset($item);
					
					$lan = Category::where('word', '=', BookFromTxt::returnValue($rowData[11]))->get()[0]['value'];
					$cat = Category::where('word', '=', BookFromTxt::returnValue(substr($rowData[9], 2)))->get()[0]['value'];
					
					Books::create([
		                'type'=>'library',
		        		'cat'=>$cat,
		                'number'=>BookFromTxt::returnValue($rowData[0]),
		                'location'=>BookFromTxt::returnValue($rowData[6]),
		        		'title'=>BookFromTxt::returnValue($rowData[1]),
		        		'img'=>'',
		        		'author'=>BookFromTxt::returnValue($rowData[2]),
		        		'isbn'=>'',
		        		'lan'=>$lan,
		        		'version'=>BookFromTxt::returnValue($rowData[4]),
		        		'no'=>BookFromTxt::returnValue($rowData[5]),
		        		'tid'=>0,
		        		'count'=>1,
		        		'buy_date'=>BookFromTxt::returnValue(str_replace('/', '-', $rowData[8])),
		        		'is_borrow'=>'true'
		        	]);
        		}
        	}
        	$i++;
    	}
    	fclose($file);
	}

    function returnValue($str) {
    	if($str == 'n/a' || $str == '')
			return '';
		else
			return $str;
    }
}