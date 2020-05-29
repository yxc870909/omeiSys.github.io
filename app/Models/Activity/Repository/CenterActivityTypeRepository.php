<?php
namespace App\Models\Activity\Repository;

use \App\Models\Activity\Entity\CenterActivityType as CenterActivityType;
use Auth;
use DB;
use View;
use Redirect;

class CenterActivityTypeRepository
{
	public static function getData($filter, $page, $limit)
	{
		return CenterActivityType::whereRaw($filter)->skip(($page-1) * $limit)->take($limit)->get();
	}
	
	public static function getAll()
	{
		return CenterActivityType::all();
	}
}