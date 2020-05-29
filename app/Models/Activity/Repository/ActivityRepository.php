<?php
namespace App\Models\Activity\Repository;

use \App\Models\Activity\Entity\Activity as Activity;
use Auth;
use DB;
use View;
use Redirect;

class ActivityRepository
{
	public static function update($filter, $updateData)
	{
		Activity::whereRaw($filter)->update($updateData);
	}

	public static function delete($filter)
	{
		Activity::whereRaw($filter)->delete();
	}

	public static function getGroupCount()
	{
		return DB::table('activity_user as a')
                    ->leftJoin('activity as b', 'a.aid', '=', 'b.id')
                    ->leftJoin('user as c', 'a.upid', '=', 'c.id')
                    ->groupBy('b.type')
                    ->select('b.type', DB::Raw('count(*) as count'))
                    ->get();
	}

	public static function getDataBySelect($filter, $select, $page, $limit)
	{
		return Activity::whereRaw($filter)->orderBy('add_date', 'desc')
						->skip(($page-1) * $limit)
						->take($limit)
						->select(DB::Raw($select))
						->get();
	}

	public static function getDataByGroupBy($filter, $group)
	{	
		return Activity::whereRaw($filter)
						->groupBy($group)
						->select('*', 
							DB::raw('count('.$group.') as count'),
							DB::raw('DATE_FORMAT(max(add_date), "%e %M.") as max_date'),
							DB::raw('DATE_FORMAT(min(add_date), "%e %M.") as min_date')
						)
						->get();
	}

	public static function getDataByWhereIn($field, $vals)
	{
		return Activity::whereIn($field, $vals)
                        ->orderBy('add_date', 'desc')
                        ->get();
	}

	public static function getPresideByUpid($upid)
	{
		$res = Activity::where('preside', 'like', '['.$upid.',%')
						->Orwhere('preside', 'like', '%,'.$upid.',%')
						->Orwhere('preside', 'like', '%,'.$upid.']')
						->where('add_date', '>=', date('Y').'-01-01')
						->get();
		if(count($res) > 0)
			return $res;

		return array();
	}
}