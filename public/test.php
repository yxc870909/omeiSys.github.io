<?php

$file = fopen('../txt/temple.txt', 'r');
echo '<meta charset="utf-8">';


$i=0;
while(!feof($file)) {

	echo print_r(explode('	', fgets($file))).'<br><br>';

	if($i == 0) fgets($file);
	else {
		$rowData = explode('	', fgets($file));

//gender
		if($rowData[2] =='乾')
			$gender =  'male';
		else if($rowData[2] =='坤')
			$gender =  'female';
		else if($rowData[2] =='童')
			$gender =  'boy';
		else if($rowData[2] =='女')
			$gender =  'girl';

		//echo returnValue($rowData[4]).'<br>';

		/*
		$user = new User;
		$user->first_name = substr($rowData[1], 0, 3);
		$user->last_name = substr($rowData[1], 3, 9);
		$user->gender = $gender;
		$user->year = returnValue($rowData[3]);
		$user->phone = returnValue($rowData[4]);
		$user->mobile = returnValue($rowData[5]);
		$user->addr = returnValue($rowData[6]);
		$user->register_date = returnValue($rowData[18]);
		$user->area = '';
		$user->position = returnPosition($rowData[28]);
		$user->work = returnValue($rowData[29]);
		*/
	}
	$i++;
}
fclose($file);


function returnValue($str) {

	if($str == 'n/a')
		return '';
	else
		return $str;
} 

function returnPosition($str) {
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
