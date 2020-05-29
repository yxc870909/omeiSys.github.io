<?php
namespace App\Models\Temple\Service;

use \App\Models\Temple\Repository\TempleRepository as TempleRepository;
use \App\Models\Category\Repository\CategoryRepository as CategoryRepository;
use \App\Models\User\Repository\UserRepository as UserRepository;
use Auth;
use DB;

class TempleService
{
	public static function update($request)
	{
		$upid = array();
        foreach(explode(',', $request['upid']) as $item) {
            $upid []= (int)$item;
        }

        $updateData = array();
        $updateData['name'] = $request['name'];
        $updateData['type'] = $request['temple_type'];
        $updateData['area'] = $request['area'];
        $updateData['addr'] = $request['addr'];
        $updateData['phone'] = $request['phone'];
        $updateData['upid'] = json_encode($upid);
        $updateData['start_date'] = str_replace(array('年','月','日'), array('-','-',''), $request['start_date']);
        $updateData['start_date2'] = $request['yyy'].'年-'.$request['yy'].'-'.$request['mm'].'-'.$request['dd'];
        if(isset($request['bookstore']) && $request['bookstore'])
            $updateData['bookstore'] = 'true';
        else
            $updateData['bookstore'] = 'false';

        if(isset($request['training']) && $request['training'])
            $updateData['training'] = 'true';
        else
            $updateData['training'] = 'false';


		TempleRepository::update($request['tid'], $updateData);
	}

	public static function getAllData()
	{
		return TempleRepository::getAllData();
	}

    public static function getTempleForArea() 
    {
        $res = TempleRepository::getTempleForArea();
        $res =  json_decode(json_encode($res), true);

        return $res;
    }

	public static function getTempleList($authID, $filter, $limit, $page)
	{
		$res = TempleRepository::getTempleList($authID, $filter, $limit, $page);
		$res =  json_decode(json_encode($res), true);

		$hash = CategoryRepository::getHashTable(array('area'));
        $res = CategoryRepository::getValueToWord($hash, 'area', $res);
        foreach($res as &$item) {
            $full_names = array();
            $upids = json_decode($item['upid']);
            foreach($upids as $upid) {
                $full_names[] = UserRepository::getFullNameFromUpid($upid);
            }
            $item['user_name'] = implode(', ', $full_names);
        }
        unset($item);

        return $res;
	}

	public static function getTempleInfoById($id)
	{
		$data = TempleRepository::getTempleDataById($id);
		$data = json_decode(json_encode($data), true);

        $hash = CategoryRepository::getHashTable(array('temple_type', 'area'));

        $full_names = array();
        $upids = json_decode($data['upid']);
        
        foreach($upids as $upid) {
            $full_names[$upid] = UserRepository::getFullNameFromUpid($upid);
        }


        $data['user_name'] = $full_names;
        $data['type_word'] = $hash['temple_type'][$data['type']]['word'];
        $data['area_word'] = $hash['area'][$data['area']]['word'];
        $data['start_date'] = str_replace(array('-', '-'), array('年', '月'), $data['start_date']).'日';

        if($data['start_date2'] != '') {
            $data['yyy'] = explode('-', $data['start_date2'])[0];
            $data['yyy'] = explode('年', $data['yyy'])[0];
            $data['yy'] = explode('-', $data['start_date2'])[1];
            $data['mm'] = explode('-', $data['start_date2'])[2];
            $data['dd'] = explode('-', $data['start_date2'])[3];
        }
        else {
            $data['yyy'] = '';
            $data['yy'] = '';
            $data['mm'] = '農曆 - 月';
            $data['dd'] = '農曆 - 日';
            $data['hh'] = '農曆  - 時';
        }

        return $data;
	}

	public static function getTempleByArea($val)
	{
		return TempleRepository::getTempleBy('area', $val);
	}

	public static function getPageCount($filter = 1)
	{
		if($filter != '1')
            $pageCount = TempleRepository::getCount($filter)/15;
        else
            $pageCount = TempleRepository::getCount()/15;

        //無條件進位
        return ceil($pageCount);
	}

	public static function getTempleName_DDL($request)
	{
		$data['data'] = TempleRepository::getAllData();
        $data['word'] = '';
        
        foreach($data['data'] as &$d) {
            
            if($d['id'] == $request) {
                $d['active'] = 'active';
                $data['word'] = $d['name'].'壇';
            }
            else
                $d['active'] = '';      
        }
        unset($d);
        if($data['word'] == '') $data['word'] = '選擇佛堂名稱';

        return $data;
	}

	public static function getOptionType($request)
	{
		$data['data'] = array(
            array('word'=>'壇主姓名', 'value'=>'name', 'active'=>''),
            array('word'=>'詳細地址', 'value'=>'addr', 'active'=>'')
            );
        $data['word'] = '';
        foreach($data['data'] as &$d) { 
            if($request == $d['value']) {
                $d['active'] = 'active';
                $data['word'] = $d['word'];
            }
        }
        unset($d);
        if($data['word'] == '') $data['word'] = '選擇搜尋';
        return $data;
	}
	

    public static function getBookStore()
    {
        $data = TempleRepository::getBookStore();
        $data = json_decode(json_encode($data), true);

        return $data;
    }
}