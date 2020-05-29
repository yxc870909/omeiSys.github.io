<?php
namespace App\Repository;
class Category
{
	public static function getPosition_CheckBoxList($request = array())
	{
		$data = \App\Models\Entity\Category::getDataByType('position');

		foreach($data as &$d) {
			foreach($request as $item) {
				if($item == $d['value'])
		     		$d['checked'] = 'checked';
			}

			if(!isset($d['checked']))
				$d['checked'] = '';
		}
		unset($d);

		return $data;
	}

	public static function getWork_CheckBoxList($request = array())
	{
		$data = \App\Models\Entity\Category::getDataByType('work');
		foreach($request as $item) {
			foreach($data as &$d) {				
				if($item == $d['value'])
		     		$d['checked'] = 'checked';
			}

			if(!isset($d['checked']))
				$d['checked'] = '';

			unset($d);
		}
		return $data;
	}

	public static function getGroup_DDL($request)
	{
		$data['data'] = \App\Models\Entity\Category::getDataByType('group');
		$data['word'] = '';
		foreach($data['data'] as &$d) {	
			if($request == $d['value']) {
	     		$d['active'] = 'active';
	     		$data['word'] = $d['word'];
			}
	     	else
	     		$d['active'] = '';
		}
		unset($d);
		if($data['word'] == '') $data['word'] = '選擇搜尋類別';
		return $data;
	}

	public static function getType_DDL($request)
	{
		$data['data'] = \App\Models\Entity\Category::getDataByType('dispatch');
		$data['word'] = '';
		foreach($data['data'] as &$d) {	
			if($request == $d['value']) {
	     		$d['active'] = 'active';
	     		$data['word'] = $d['word'];
			}
	     	else
	     		$d['active'] = '';
		}
		unset($d);
		if($data['word'] == '') $data['word'] = '選擇搜尋類別';
		return $data;
	}

	public static function getBooksType_DDL($request)
	{
		$data['data'] = \App\Models\Entity\Category::getDataByType('books_type');
		$data['word'] = '';
		foreach($data['data'] as &$d) {	
			if($request == substr($d['value'], 0 ,-3)) {
	     		$d['active'] = 'active';
	     		$data['word'] = $d['attribute'];
			}
	     	else
	     		$d['active'] = '';
		}
		unset($d);
		if($data['word'] == '') $data['word'] = '選擇搜尋類別';
		return $data;
	}

	public static function getArea_DDL($request)
	{
		$data['data'] = \App\Models\Entity\Category::getDataByType('area');
		$data['word'] = '';
		foreach($data['data'] as &$d) {	
			if($request == $d['value']) {
	     		$d['active'] = 'active';
	     		$data['word'] = $d['word'];
			}
	     	else
	     		$d['active'] = '';
		}
		unset($d);
		if($data['word'] == '') $data['word'] = '選擇佛堂區域';
		return $data;	
	}

	public static function getTempleType_DDL($request)
	{
		$data['data'] = \App\Models\Entity\Category::getDataByType('temple_type');
		$data['word'] = '';
		foreach($data['data'] as &$d) {	
			if($request == $d['value']) {
	     		$d['active'] = 'active';
	     		$data['word'] = $d['word'];
			}
	     	else
	     		$d['active'] = '';
		}
		unset($d);
		if($data['word'] == '') $data['word'] = '選擇佛壇性質';
		return $data;	
	}

	public static function getAttr_DDL($request)
	{
		$data['data'] = \App\Models\Entity\Category::getDataByAttr($request);
		$data['word'] = '';
		foreach($data['data'] as &$d) {	
			if($request == $d['value']) {
	     		$d['active'] = 'active';
	     		$data['word'] = $d['word'];
			}
	     	else
	     		$d['active'] = '';

	     	if($request=='books_type')
	     		$d['value'] = substr($d['value'], 0, -3);
		}
		unset($d);
		if($data['word'] == '') $data['word'] = '選擇搜尋類別';
		return $data;
	}
}