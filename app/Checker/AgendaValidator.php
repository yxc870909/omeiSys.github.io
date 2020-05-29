<?php
namespace App\Checker;

use App\Http\Requests\Request;
use App\Validator\AgendaValidator as AgendaVal;

class AgendaValidator
{
	public static function AddAgendalValidator($request) {

		return AgendaVal::AddAgendalValidator($request);
	}

	public static function AddThreeAgendalValidator($request) {

		return AgendaVal::AddThreeAgendalValidator($request);
	}
}