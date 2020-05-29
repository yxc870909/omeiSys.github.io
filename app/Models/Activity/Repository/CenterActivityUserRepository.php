<?php
namespace App\Models\Activity\Repository;

use \App\Models\Activity\Entity\CenterActivityUser as CenterActivityUser;
use \App\Models\User\Service\UserService as UserService;
use Auth;
use DB;

class CenterActivityUserRepository
{
	public static function delete($filter)
	{
	    CenterActivityUser::whereRaw($filter)->delete();
	}

	public static function getCount($filter, $page, $limit)
	{
	    return CenterActivityUser::whereRaw($filter)
	            ->skip(($page-1) * $limit)
	            ->take($limit)
	            ->count();
	}

	public static function getData($filter, $page, $limit)
	{
	    return CenterActivityUser::whereRaw($filter)
	            ->skip(($page-1) * $limit)
	            ->take($limit)
	            ->get();
	}

	public static function getActivityUser($filter, $page, $limit)
	{
		$caid = $filter.explode('=', $filter)[1];
		return DB::table('center_activity_user')
                ->leftJoin('center_activity', 'center_activity_user.caid', '=', 'center_activity.id')
                ->leftJoin('center_record', 'center_activity_user.upid', '=', 'center_record.upid')
                ->whereRaw($filter)
                ->skip(($page-1) * $limit)
                ->take($limit)
                ->groupBy('center_activity_user.name')
                ->select('center_activity_user.*', 
                        DB::Raw('case when (center_record.upid>0 and center_record.caid='.$caid.') then "finish" else "active" end as status'),
                        DB::Raw("'".UserService::UserTypeValidator('AddCenter_Status', Auth::user()->type)."' as `show`"))
                ->get();
	}
}