<?php

use Illuminate\Database\Seeder;
use \App\Models\Entity\Agenda as Agenda;
use \App\Models\Entity\Category as Category;
use \App\Models\User\Entity\User as User;
use \App\Models\Entity\Temple as Temple;

class AgendaFromTxt extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('txt/agenda.txt', 'r');

        $i = 0;
        while(!feof($file)) {

        	if($i == 0) fgets($file);
        	else {
        		$rowData = explode('	', fgets($file));

        		if(is_array($rowData) && !empty($rowData)) {

        			foreach($rowData as &$item)
						trim($item);
					unset($item);

					$tid = Temple::where('name', '=', AgendaFromTxt::returnValue($rowData[4]))->get();
					$type = Category::where('word', '=', AgendaFromTxt::returnValue($rowData[2]))->get()[0]['value'];

					Agenda::create([
		                'tid'=>AgendaFromTxt::returnCheckCountValue($tid),
		                'type'=>$type,
		        		'Dianchuanshi'=>implode('', AgendaFromTxt::returnMutilUser($rowData[5], array())),
		                'preside'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[5], array())),
		        		'upper'=>implode(AgendaFromTxt::returnMutilUser($rowData[7], array())),
		        		'lowwer'=>implode(AgendaFromTxt::returnMutilUser($rowData[8], array())),
		        		'action'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[9], array())),
		        		'support'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[10], array())),
		        		'counseling'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[12], array())),
		        		'write'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[11], array())),
		        		'towel'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[16], array())),
		        		'music'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[15], array())),
		        		'service1'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[18], array())),
		        		'traffic'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[20], array())),
		        		'affairs'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[22], array())),
		        		'cooker'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[27], array())),
		        		'uplow'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[17], array())),
		        		'sambo'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[24], array())),
		        		'add'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[13], array())),
		        		'aegis'=>implode(AgendaFromTxt::returnMutilUser($rowData[19], array())),
		        		'flower'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[21], array())),
		        		'accounting'=>json_encode(AgendaFromTxt::returnMutilUser($rowData[14], array())),
		        		'course_title'=>json_encode(AgendaFromTxt::returnCourse(array($rowData[36],$rowData[37],$rowData[38],$rowData[39]))),
		        		'course_lecturer'=>json_encode(AgendaFromTxt::returnCourseTitle(array($rowData[36],$rowData[37],$rowData[38],$rowData[39]))),
		                'add_date'=>$rowData[1],
		        	]);

        		}
        	}
			$i++;
        }
        fclose($file);
    }

    private static function returnValue($str) {
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

	private static function returnMutilUser($rowData, $dist) {

		$rowData = explode('、', $rowData);
		$i = 0;
		foreach(AgendaFromTxt::returnValue($rowData) as $item) {
			$res = User::where('first_name', '=', substr($item, 0, 3))
					->where('last_name', '=', substr($item, 3, 9))
						->get();
			$dist[$i] = AgendaFromTxt::returnCheckCountValue($res);
			$i++;
		}

		return $dist;
	}

	private static function returnCourse($rowData) {
		
		$dist = array();
		$i = 0;
		foreach($rowData as $item) {
			$dist[$i] = explode('-', $item)[0];
			$i++;
		}

		return $dist;
	}

	private static function returnCourseTitle($rowData) {

		$dist = array();
		$i = 0;
		foreach($rowData as $item) {
			$dist[$i] = explode('-', $item)[1];
			$i++;
		}

		return $dist;
	}
}
