<?php
namespace App\Validator;

use App\Http\Requests\Request;
use Validator;

class BooksValidator
{
	public static function AddLibraryBookValidator($request) {

		$rules = array(
			'temple' => array('required'),
			'location' => array('required'),
			'book_name' => array('required'),
			'count' => array('required'),
			'fileName' => array('required'),
			'type' => array('required'),
			'lan' => array('required'),
			'buy_date' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}

	public static function EditLibraryBookValidator($request) {

		$rules = array(
			'temple' => array('required'),
			'location' => array('required'),
			'book_name' => array('required'),
			'count' => array('required'),
			'fileName' => array('required'),			
			'type' => array('required'),
			'lan' => array('required'),
			'buy_date' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}

	public static function AddSnscriptionBookValidator($request) {

		$rules = array(
			'temple' => array('required'),
			'SubscriptionCount' => array('required'),
			'book_name' => array('required'),
			'fileName' => array('required'),
			'type' => array('required'),
			'type2' => array('required'),
			'lan' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}

	public static function EditSnscriptionBookValidator($request) {

		$rules = array(
			'temple' => array('required'),
			'count' => array('required'),
			'book_name' => array('required'),
			'fileName' => array('required'),
			'type' => array('required'),
			'type2' => array('required'),
			'lan' => array('required')
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}

	public static function EditReceiveBookValidator($request) {

		$rules = array(
			'temple' => array('required'),
			'book_name' => array('required'),
			'fileName' => array('required'),
			'type' => array('required'),
			'lan' => array('required'),
			'pub_year' => array('required'),
			);
		$error_msg = array('required'=>'* 欄位不能空白');

		return Validator::make($request, $rules, $error_msg);
	}
}