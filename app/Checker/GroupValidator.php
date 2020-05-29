<?php
namespace App\Checker;

use App\Http\Requests\Request;
use App\Validator\GroupValidator as GrouptVal;

class GroupValidator
{
	public static function AddGroupValidator($request) {

		return GrouptVal::AddGroupValidator($request);
	}
}