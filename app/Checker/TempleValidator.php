<?php
namespace App\Checker;

use App\Http\Requests\Request;
use App\Validator\TempleValidator as TempleVal;

class TempleValidator
{
	public static function TempleModelValidator($request) {

		return TempleVal::TempleModelValidator($request);
	}
}