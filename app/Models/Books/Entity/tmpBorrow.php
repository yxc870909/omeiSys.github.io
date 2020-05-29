<?php

namespace App\Models\Books\Entity;

use Illuminate\Database\Eloquent\Model;
use DB;

class tmpBorrow extends Model
{
	protected $table = 'tmp_borrow';
	public $timestamps = false; 
}