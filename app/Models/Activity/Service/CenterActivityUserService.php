<?php
namespace App\Models\Activity\Service;

use \App\Models\Activity\Repository\CenterActivityUserRepository as CenterActivityUserRepository;
use Auth;
use DB;
use View;
use Redirect;

class CenterActivityUserService
{
	public static function delete($filter)
	{
		CenterActivityUserRepository::delete($filter);
	}

	public static function getCount($filter, $page, $limit)
	{
		return CenterActivityUserRepository::getCount($filter, $page, $limit);
	}

	public static function getData($filter, $page, $limit)
	{
		$data = CenterActivityUserRepository::getData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
	
	public static function getActivityUser($filter, $page, $limit)
	{
		$data = CenterActivityUserRepository::getActivityUser($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}