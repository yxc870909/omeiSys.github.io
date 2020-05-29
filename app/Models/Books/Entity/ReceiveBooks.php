<?php

namespace App\Models\Books\Entity;

use Illuminate\Database\Eloquent\Model;
use DB;

class ReceiveBooks extends Model
{
	protected $table = 'receive_books';

	public static function getCount()
	{
		return ReceiveBooks::count();
	}
}