<?php
namespace App\Validator;

use App\Http\Requests\Request;
use Validator;

class AgendaValidator
{
	public static function AddAgendalValidator($request) {

		$rules = array(
			'area' => array('required'),
			'tid' => array('required'),
			'add_date' => array('required'),
			'yyy' => array('required'),
			'yy' => array('required'),
			'mm' => array('required'),
			'dd' => array('required'),
			'Dianchuanshi' => array('required'),
			'upper' => array('required'),
			'lowwer' => array('required'),
			'action' => array('required'),
			'preside' => array('required'),
			'support' => array('required'),
			'write' => array('required'),
			'towel' => array('required'),
			'music' => array('required'),
			'cooker' => array('required'),
			'uplow' => array('required'),
			'sambo' => array('required'),
			'add' => array('required'),
			'accounting' => array('required')			
			);

		$error_msg = array(
			'required'=>'* 該欄位項目尚未新增辦事人員');

		return Validator::make($request, $rules, $error_msg);
	}

	public static function AddThreeAgendalValidator($request) {

		$rules = array(
			'area' => array('required'),
			'tid' => array('required'),
			'add_date' => array('required'),
			'yyy' => array('required'),
			'yy' => array('required'),
			'mm' => array('required'),
			'dd' => array('required')
			);

		$error_msg = array(
			'required'=>'* 該欄位項目尚未新增辦事人員');

		return Validator::make($request, $rules, $error_msg);
	}
}