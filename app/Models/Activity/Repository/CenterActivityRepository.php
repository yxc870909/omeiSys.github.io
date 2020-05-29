<?php
namespace App\Models\Activity\Repository;

use \App\Models\Activity\Entity\CenterActivity as CenterActivity;
use Auth;
use DB;
use View;
use Redirect;

class CenterActivityRepository
{
	public static function getDataByGroupByWithUser($filter, $group)
	{
		return DB::table('center_activity')
            			->leftJoin('center_activity_user', 'center_activity.id', '=', 'center_activity_user.caid')
            			->whereRaw($filter)
            			->groupBy($group)
            			->orderBy('add_date', 'desc')
            			->select('center_activity.*', DB::Raw('count(center_activity_user.id) as count'))
            			->get();
	}

	public static function getDataByGroupBy($filter, $group)
	{
		return CenterActivity::whereRaw($filter)
						->groupBy($group)
						->select('*', DB::raw('count('.$group.') as count'),
							DB::raw('DATE_FORMAT(max(add_date), "%e %M.") as max_date'),
							DB::raw('DATE_FORMAT(min(add_date), "%e %M.") as min_date')
						)
						->get();
	}

	public static function getDataBySelect($filter, $select, $page, $limit)
	{
		return CenterActivity::whereRaw($filter)->orderBy('add_date', 'desc')
							->skip(($page-1) * $limit)
							->take($limit)
							->select(DB::Raw($select))
							->get();
	}
}