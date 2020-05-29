<?php
namespace App\Validator;

use App\Http\Requests\Request;
use Validator;

class AccountValidator
{
	public static function LoginValidator($request) {

		$rules = array(
			'account' => array('required'),
			'password' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}

	public static function RegisterValidator($request) {

		$rules = array(
			'account' => array('required'),
			'password' => array('required'),
			'confirm' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}
}