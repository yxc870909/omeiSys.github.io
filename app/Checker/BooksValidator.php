<?php
namespace App\Checker;

use App\Http\Requests\Request;
use App\Validator\BooksValidator as BooksVal;

class BooksValidator
{
	public static function AddLibraryBookValidator($request) {

		return BooksVal::AddLibraryBookValidator($request);
	}

	public static function EditLibraryBookValidator($request) {

		return BooksVal::EditLibraryBookValidator($request);
	}

	public static function AddSnscriptionBookValidator($request) {

		return BooksVal::AddSnscriptionBookValidator($request);
	}

	public static function EditSnscriptionBookValidator($request) {

		return BooksVal::EditSnscriptionBookValidator($request);
	}

	public static function EditReceiveBookValidator($request) {

		return BooksVal::EditReceiveBookValidator($request);
	}
}