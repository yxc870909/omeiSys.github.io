<?php
namespace App\Models\User\Service;

use \App\Models\User\Repository\UserRepository as UserRepository;
use \App\Models\Activity\Repository\ActivityRepository as ActivityRepository;
use \App\Models\Category\Repository\CategoryRepository as CategoryRepository;
use \App\Models\Temple\Repository\TempleRepository as TempleRepository;
use \App\Models\Group\Repository\GroupRepository as GroupRepository;
use Auth;
use DB;

class UserService
{
	public static function update($upid, $updteData)
	{
	    UserRepository::update($upid, $updteData);
	}

	public static function getUserBoxInfo()
	{
		//get user, regist, temple, bookbrrow count
		$userInfo = UserRepository::getUserBoxInfo();
		$userInfo = json_decode(json_encode($userInfo), true);

		//get activity presider by this year 
		$activity = ActivityRepository::getPresideByUpid(Auth::user()->id);
    	$activity = json_decode(json_encode($activity), true);
        
    	$unit = array();
    	foreach($activity as $atvty) {
    		$unit[] = $atvty['type'];
    	}

    	$data = array();
    	$hash = CategoryRepository::getHashTable(array('group','group_type','position'));

        $position = json_decode(Auth::user()->position);
        foreach($position as &$item) {
            $item = $item!='' ? $hash['position'][$item]['word'] : '';
        }
        unset($item);

        //get group
        $groups = array();
        $res = GroupRepository::getGroup(implode(' and ', array(
        	'upid='.Auth::user()->id,
        	'year='.date('Y')
        	)));
        $res = json_decode(json_encode($res), true);
        if(count($res) > 0) {
            foreach($res as $item) {
                $groups[] = $hash['group_type'][$item['type']]['word'].'('.$hash['group'][$item['group']]['word'].')';
            }
        }
        
		$data['position'] = '天職: '.implode(', ', $position);
		$data['name'] = '佛堂: '.$userInfo['name'].'壇';
		$data['preside'] = '操持: '.implode(',', $unit);
		$data['group'] = '組別: '.implode(', ', $groups);
		$data['count'] = $userInfo['count'];

		return $data;
	}

	public static function UserTypeValidator($eventName, $userType)
	{
		return UserRepository::UserTypeValidator($eventName, $userType);
	}

	public static function getPageCount($filter, $upids)
	{	
		if($filter != '1' || count($upids) > 0)
            $pageCount = UserRepository::getPageCount($filter, $upids)/15;
        else
            $pageCount = UserRepository::getPageCount()/15;

        //無條件進位
        return ceil($pageCount);
	}

	public static function getAllHostOfTemple()
	{
		$temples = TempleRepository::getAllData();
        foreach($temples as $item) {
            $upid = json_decode($item['upid']);
            foreach($upid as $item2)
                $upids[] = $item2;
        }
        $upids = array_unique($upids);

        return $upids;
	}

	public static function getUsersOfTemple($authID, $filter, $page)
	{
		$users = UserRepository::getUsers($authID, $filter, 15, $page);
        $users = json_decode(json_encode($users), true);

        return $users;
	}

	public static function getUsersOfTempler($authID, $filter, $page)
	{
		$users = null;
        $upids = array();
        if($filter) {
            $upids = UserService::getAllHostOfTemple();

            $users = UserRepository::getUsersByUpid($authID, $filter, $upids, 15, $page);
            $users = json_decode(json_encode($users), true);
        }

        return $users;
	}

	public static function getPersonnelViewInfo($upid)
	{
		$data = UserRepository::getUserAndMainFamliy($upid);

        return $data;
	}

	public static function SearchUser($search)
	{
		$filter = array();
		$filter[] = "concat(a.first_name,a.last_name) = '".$search."'";
		$filter[] = "a.email = '".$search."'";
		$filter = implode(' or ', $filter);
		$user = UserRepository::getUsers(0, $filter, 1, 0);

		return $user;
	}

	public static function getUser($filter, $limit, $page)
	{
		$user = UserRepository::getUsers(0, $filter, $limit, $page);
		$user = json_decode(json_encode($user), true);

        return $user;
	}

	public static function getUsersByWhereIn($field, $vals)
	{
		$data = UserRepository::getUsersByWhereIn($field, $vals);
		$data = json_decode(json_encode($data), true);

		return $data;
	}

	public static function find($upid)
	{
		$user = UserRepository::getUsers(0, 'a.id='.$upid, 1, 0);
		$user = json_decode(json_encode($user), true);

        return $user;
	}
}