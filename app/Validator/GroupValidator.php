<?php
namespace App\Validator;

use App\Http\Requests\Request;
use Validator;

class GroupValidator
{
	public static function AddGroupValidator($request) {

		$rules = array(
			'year' => array('required'),
			'area' => array('required')
			'group' => array('required'),
			'leader' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}
}