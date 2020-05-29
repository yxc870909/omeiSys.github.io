<?php

use Illuminate\Database\Seeder;
use \App\Models\Entity\Temple as Temple;
use \App\Models\Entity\Category as Category;

class TempleFromTxt extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('txt/temple.txt', 'r');

        $i = 0;
        while(!feof($file)) {

        	if($i == 0) fgets($file);
        	else {
        		$rowData = explode('	', fgets($file));
        		
				if(is_array($rowData) && !empty($rowData)) {

					foreach($rowData as &$item)
						trim($item);
					unset($item);

					if($rowData[2] == '家壇')
	        			$type = 'family';
	        		else if($rowData[2] == '公壇')
	        			$type = 'public';

	        		$area = Category::where('word', '=', TempleFromTxt::returnValue($rowData[3]))->get()[0]['value'];
	        		if(TempleFromTxt::returnValue($rowData[11]) != '')
	        			$start_date2 = substr($rowData[11], 6,7).'-'.substr($rowData[11], 19,6).'-'.substr($rowData[11], 25,6).'-'.substr($rowData[11], 31,6);
	        		else
	        			$start_date2 = '';

	        		Temple::create([
		                'name'=>TempleFromTxt::returnValue($rowData[1]),
		                'type'=>$type,
		                'area'=>$area,
		                'addr'=>TempleFromTxt::returnValue($rowData[8]),
		                'phone'=>TempleFromTxt::returnValue($rowData[9])=='' ? TempleFromTxt::returnValue($rowData[5]) : TempleFromTxt::returnValue($rowData[9]),
		                'start_date'=>TempleFromTxt::returnValue($rowData[10]),
		                'start_date2'=> $start_date2,
		                'bookstore'=>'false',
		                'training'=>'false',
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
