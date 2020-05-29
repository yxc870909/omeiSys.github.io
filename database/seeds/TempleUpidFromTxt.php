<?php

use Illuminate\Database\Seeder;
use \App\Models\Entity\Temple as Temple;
use \App\Models\Entity\Category as Category;
use \App\Models\User\Entity\User as User;

class TempleUpidFromTxt extends Seeder
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

					$update = array();
					if(TempleUpidFromTxt::returnValue($rowData[7]) != '') {

						$upids = array();
						$names = explode('、', $rowData[7]);
						foreach($names as $name) {
							$res = User::where('first_name', '=', substr($name, 0, 3))
									->where('last_name', '=', substr($name, 3, 9))
									->get();
							$upids[] = TempleUpidFromTxt::returnCheckCountValue($res);
						}
						
						$update['upid'] = json_encode($upids);
					}

					if(count($update) > 0) {
						Temple::where('name', '=', TempleUpidFromTxt::returnValue($rowData[1]))
							->where('addr', '=', TempleUpidFromTxt::returnValue($rowData[8]))
							->update($update);
						}
					
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

    private static function returnCheckCountValue($obj) {
		if(count($obj) > 0) {
			return $obj[0]['id'];
		}
		else
			return 0;
	}
}
