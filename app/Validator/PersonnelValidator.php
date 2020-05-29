<?php
namespace App\Validator;

use App\Http\Requests\Request;
use Validator;

class PersonnelValidator
{
	public static function AddSinglePersonnelValidator($request) {

		$rules = array(
			'area' => array('required'),
			'tid' => array('required'),
			'add_date' => array('required'),
			'yyy' => array('required'),
			'yy' => array('required'),
			'mm' => array('required'),
			'dd' => array('required'),
			'hh' => array('required')
			);
		$error_msg = array(
			'required'=>'* 該欄位項目尚未新增辦事人員');

		return Validator::make($request, $rules, $error_msg);
	}

	public static function AddMultiPersonnelValidator($request) {

		$rules = array(
			'area' => array('required'),
			'tid' => array('required'),
			'add_date' => array('required'),
			'yyy' => array('required'),
			'yy' => array('required'),
			'mm' => array('required'),
			'dd' => array('required'),
			'hh' => array('required'),
			'Dianchuanshi' => array('required'),
			'upper' => array('required'),
			'lowwer' => array('required'),
			'add' => array('required'),
			'peper' => array('required'),
			'sambo' => array('required'),
			'Introduction' => array('required'),
			'action' => array('required'),
			'support' => array('required'),
			'peper' => array('required'),
			'preside' => array('required')
			);
		$error_msg = array(
			'required'=>'* 該欄位項目尚未新增辦事人員');

		return Validator::make($request, $rules, $error_msg);
	}
}