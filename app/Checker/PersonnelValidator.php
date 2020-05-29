<?php
namespace App\Checker;

use App\Http\Requests\Request;
use App\Validator\PersonnelValidator as PersonnelVal;

class PersonnelValidator
{
	public static function AddSinglePersonnelValidator($request) {

		return PersonnelVal::AddSinglePersonnelValidator($request);
	}

	public static function AddMultiPersonnelValidator($request) {

		return PersonnelVal::AddMultiPersonnelValidator($request);
	}
}