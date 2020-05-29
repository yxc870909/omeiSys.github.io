<?php
namespace App\Models\Books\Service;

use \App\Models\Books\Repository\RecvApplicationRepository as RecvApplicationRepository;
use Auth;
use DB;

class RecvApplicationService
{
	public static function update($id, $updateData)
    {
        RecvApplicationRepository::update($id, $updateData);
    }
    
	public static function getPageCount($filter)
	{
		$pageCount = RecvApplicationRepository::getPageCount($filter)/15;
		//無條件進位
        return ceil($pageCount);
	}

	public static function getApplicationData($filter = 1, $page, $limit)
	{
		$data = RecvApplicationRepository::getApplicationData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		foreach($data as &$item) {
			if($item['status'] == 'process') {
				$item['color'] = 'red';
				$item['statusWord'] = '申請中';
			}
			if($item['status'] == 'finish') {
				$item['color'] = 'green';
				$item['statusWord'] = '已領取';
			}
		}
		unset($item);

		return $data;
	}
}