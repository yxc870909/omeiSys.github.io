<?php
namespace App\Validator;

use App\Http\Requests\Request;
use Validator;

class TempleValidator
{
	public static function TempleModelValidator($request) {

		$rules = array(
			'temple_type' => array('required'),
			'name' => array('required'),
			'area' => array('required'),
			'addr' => array('required'),
			'phone' => array('required'),
			'upid' => array('required'),
			'start_date' => array('required'),
			'yyy' => array('required'),
			'yy' => array('required'),
			'mm' => array('required'),
			'dd' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}
}