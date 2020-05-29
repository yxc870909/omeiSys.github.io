<?php
namespace App\Models\Group\Repository;

use \App\Models\Group\Entity\Group as Group;
use Auth;
use DB;

class GroupRepository
{
	public static function getGroup($filter = "1")
	{
		return DB::table('groups')->whereRaw($filter)->get();
	}
}