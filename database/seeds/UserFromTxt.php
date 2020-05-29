<?php

use Illuminate\Database\Seeder;
use \App\Models\User\Entity\User as User;
use \App\Models\Entity\Category as Category;
use \App\Models\Entity\Regist as Regist;
use \App\Models\Entity\Temple as Temple;

class UserFromTxt extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
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


        $file = fopen('txt/user.txt', 'r');

        $i=0;
        $gender = '';
		while(!feof($file)) {

			if($i == 0) fgets($file);
			else {
				$rowData = explode('	', fgets($file));
				
				if($rowData[2] =='乾')
					$gender = 'male';
				else if($rowData[2] =='坤')
					$gender = 'female';
				else if($rowData[2] =='童')
					$gender = 'boy';
				else if($rowData[2] =='女')
					$gender = 'girl';
				
				if(UserFromTxt::returnValue($rowData[29]) != '')
					$work = Category::where('word', '=', $rowData[29])->get()[0]['value'];
				else
					$work = '';
				$area = Category::where('word', '=', $rowData[23])->get()[0]['value'];
				$Dianchuanshi = User::where('Dianchuanshi', '=', $rowData[24])->get();
				$Introducer = User::where('Introducer', '=', $rowData[25])->get();
				$Guarantor = User::where('Guarantor', '=', $rowData[26])->get();
				User::create([
	                'type'=>'General',
	                'first_name'=>substr($rowData[1], 0, 3),
	                'last_name'=>substr($rowData[1], 3, 9),
	                'gender'=>$gender,
	                'year'=>UserFromTxt::returnValue($rowData[3]),
	                'phone'=>UserFromTxt::returnValue($rowData[4]),
	                'mobile'=> UserFromTxt::returnValue($rowData[5]),
	                'addr'=>UserFromTxt::returnValue($rowData[6]),
	                'register_date'=>UserFromTxt::returnValue($rowData[18]),
	                'area'=>$area,
	                'Dianchuanshi'=>'',
	                'Introducer'=>'',
	                'Guarantor'=>'',
	                'position'=>UserFromTxt::returnPosition($rowData[28]),
	                'work'=>$work,
	                'father'=>implode(UserFromTxt::returnMutilUser($rowData[11], array())),
	                'mother'=>implode(UserFromTxt::returnMutilUser($rowData[12], array())),
	                'spouse'=>implode(UserFromTxt::returnMutilUser($rowData[15], array())),
	                'brosis'=>json_encode(UserFromTxt::returnMutilUser($rowData[14], array())),
	                'child'=>json_encode(UserFromTxt::returnMutilUser($rowData[13], array())),
	                'relative'=>json_encode(UserFromTxt::returnMutilUser($rowData[16], array())),
	                'regist_id'=>$i-1,
	        	]);

	        	Regist::create([
	                'tid'=>0,
	            ]);
			}
			$i++;
			
		}
		fclose($file);
		
		
		$file = fopen('txt/user.txt', 'r');

        $i=0;
        $gender = '';
		while(!feof($file)) {

			if($i == 0) fgets($file);
			else {
				$rowData = explode('	', fgets($file));
				
				
				$update = array();

				$res = User::where('first_name', '=', substr($rowData[24], 0, 3))
							->where('last_name', '=', substr($rowData[24], 3, 9))
							->get();
				$update['Dianchuanshi'] = UserFromTxt::returnCheckCountValue($res);
				$res = User::where('first_name', '=', substr($rowData[25], 0, 3))
							->where('last_name', '=', substr($rowData[25], 3, 9))
							->get();
				$update['Introducer'] = UserFromTxt::returnCheckCountValue($res);
				$res = User::where('first_name', '=', substr($rowData[26], 0, 3))
							->where('last_name', '=', substr($rowData[26], 3, 9))
							->get();
				$update['Guarantor'] = UserFromTxt::returnCheckCountValue($res);
				if(UserFromTxt::returnValue($rowData[26]) != '') {
					$res = Temple::where('name', '=', $rowData[20])->get();
					if(count($res) > 0) {
						Regist::where('id', '=', 
										User::where('first_name', '=', substr($rowData[1], 0, 3))
										->where('last_name', '=', substr($rowData[1], 3, 9))
										->get()[0]['regist_id'])
							->update(array('tid'=>$res[0]['id']));
					}
				}

				$user = User::where('first_name', '=', substr($rowData[1], 0, 3))
							->where('last_name', '=', substr($rowData[1], 3, 9))
							->where('addr', '=', UserFromTxt::returnValue($rowData[6]))
							->update($update);
				
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

	private static function returnPosition($str) {
		if($str == 'n/a')
			return '';
		else {
			$posit = array();
			foreach(explode(',', $str) as $item) {
				$posit[] = 'position'.$item;
			}

			return json_encode($posit);
		}
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
		foreach(UserFromTxt::returnValue($rowData) as $item) {
			$res = User::where('first_name', '=', substr($item, 0, 3))
					->where('last_name', '=', substr($item, 3, 9))
						->get();
			$dist[$i] = UserFromTxt::returnCheckCountValue($res);
			$i++;
		}

		return $dist;
	}
}
