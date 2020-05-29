<?php
namespace App\Models\Activity\Service;

use \App\Models\Activity\Repository\CenterActivityRepository as CenterActivityRepository;
use \App\Models\User\Repository\UserRepository as UserRepository;
use Auth;
use DB;

class CenterActivityService
{
	public static function getData($filter, $select, $page, $limit)
	{
		$data = CenterActivityRepository::getDataBySelect($filter, $select, $page, $limit);
        $data = json_decode(json_encode($data), true);
        
        return $data;
	}

	public static function getDataByGroupByWithUser($filter, $group)
	{
		$data = CenterActivityRepository::getDataByGroupByWithUser($filter, $group);
        $data = json_decode(json_encode($data), true);

        return $data;
	}

	public static function getDataByGroupBy($filter, $group)
	{
		$data = CenterActivityRepository::getDataByGroupBy($filter, $group);
        $data = json_decode(json_encode($data), true);

        return $data;
	}

	public static function getActivityYears()
	{
		$data = CenterActivityRepository::getDataBySelect('1', 'distinct add_date', 1, 9999);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}