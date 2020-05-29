<?php
namespace App\Models\Activity\Repository;

use \App\Models\Activity\Entity\ActivityUser as ActivityUser;
use Auth;
use DB;

class ActivityUserRepository
{
  public static function delete($filter)
  {
    ActivityUser::whereRaw($filter)->delete();
  }

  public static function getCount($filter, $page, $limit)
  {
    return ActivityUser::whereRaw($filter)
            ->skip(($page-1) * $limit)
            ->take($limit)
            ->count();
  }

  public static function getData($filter, $page, $limit)
  {
    return ActivityUser::whereRaw($filter)
            ->skip(($page-1) * $limit)
            ->take($limit)
            ->get();
  }
  
	public static function getActivityUser($filter, $page, $limit)
	{
		return DB::table('activity_user')
                    ->leftJoin('activity', 'activity_user.aid', '=', 'activity.id')
                    ->leftJoin('user', 'activity_user.upid', '=', 'user.id')
                    ->leftJoin('activity_attend', 'activity_user.id', '=', 'activity_attend.auid')
                    ->whereRaw($filter)
                    ->skip(($page-1) * $limit)
                    ->take($limit)
                    ->groupBy('activity_user.name')
                    ->select('activity_user.*', 'activity.type',
                              DB::Raw('count(activity_attend.auid) as count'))
                    ->get();
	}

     public static function getActivityUserByaid($filter, $page, $limit)
     {
          return ActivityUser::whereRaw($filter)
                      ->skip(($page-1) * $limit)
                      ->take($limit)
                      ->groupBy('aid')
                      ->get();
     }
}