<?php
namespace App\Models\Activity\Repository;

use \App\Models\Activity\Entity\ActivityType as ActivityType;
use Auth;
use DB;
use View;
use Redirect;

class ActivityTypeRepository
{
	public static function getData($filter, $page, $limit)
	{
		return ActivityType::whereRaw($filter)->skip(($page-1) * $limit)->take($limit)->get();
	}

	public static function getAll()
	{
		return ActivityType::all();
	}
}