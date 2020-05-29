<?php
namespace App\Models\Activity\Service;

use \App\Models\Activity\Repository\ActivityRepository as ActivityRepository;
use \App\Models\User\Repository\UserRepository as UserRepository;
use Auth;
use DB;

class ActivityService
{
	public static function update($filter, $updateData)
	{
		ActivityRepository::update($filter, $updateData);
	}

	public static function delete($filter)
	{
		ActivityRepository::delete($filter);
	}

	public static function getData($filter, $select, $page, $limit)
	{
		$data = ActivityRepository::getDataBySelect($filter, $select, $page, $limit);
        $data = json_decode(json_encode($data), true);
        
        return $data;
	}

	public static function getGroupCount()
	{
		$data = ActivityRepository::getGroupCount();
        $data = json_decode(json_encode($data), true);

        return $data;
	}

	public static function getActivityYears()
	{
		$data = ActivityRepository::getDataBySelect('1', 'distinct add_date', 1, 9999);
		$data = json_decode(json_encode($data), true);

		return $data;
	}

	public static function getDataByGroupBy($filter, $group)
	{
		$data = ActivityRepository::getDataByGroupBy($filter, $group);
        $data = json_decode(json_encode($data), true);

        return $data;
	}

	public static function getDataByWhereIn($field, $vals)
	{
		$data = ActivityRepository::getDataByWhereIn($field, $vals);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}