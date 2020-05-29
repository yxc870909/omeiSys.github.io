<?php
namespace App\Checker;

use App\Http\Requests\Request;
use App\Validator\AccountValidator as AccountVal;

class AccountValidator
{
	public static function LoginValidator($request) {

		return AccountVal::LoginValidator($request);
	}

	public static function RegisterValidator($request) {

		return AccountVal::RegisterValidator($request);
	}
}