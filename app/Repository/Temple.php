<?php
namespace App\Repository;
class Temple
{
	public static function getTempleName_DDL($request)
	{
		$data['data'] = \App\Models\Entity\Temple::getAllTemples()->toArray();
		$data['word'] = '';
		
		foreach($data['data'] as &$d) {
			
			if(isset($d['id'])) {
				if($d['id'] == $request) {
		     		$d['active'] = 'active';
		     		$data['word'] = $d['name'].'壇';
				}
				else
					$d['active'] = '';		
			}
		}
		unset($d);
		if($data['word'] == '') $data['word'] = '選擇佛堂名稱';

		return $data;	
	}
}