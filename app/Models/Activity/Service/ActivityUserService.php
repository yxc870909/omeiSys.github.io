<?php
namespace App\Models\Activity\Service;

use \App\Models\Activity\Repository\ActivityUserRepository as ActivityUserRepository;
use Auth;
use DB;
use View;
use Redirect;

class ActivityUserService
{
	public static function delete($filter)
	{
		ActivityUserRepository::delete($filter);
	}

	public static function getCount($filter, $page, $limit)
	{
		return ActivityUserRepository::getCount($filter, $page, $limit);
	}

	public static function getData($filter, $page, $limit)
	{
		$data = ActivityUserRepository::getData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
	
	public static function getActivityUser($filter, $page, $limit)
	{
		$data = ActivityUserRepository::getActivityUser($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}

	public static function getActivityUserByaid($filter, $page, $limit)
	{
		$data = ActivityUserRepository::getActivityUserByaid($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}