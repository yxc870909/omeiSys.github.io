<?php
namespace App\Models\Books\Service;

use \App\Models\Books\Repository\ReceiveBooksRepository as ReceiveBooksRepository;
use Auth;
use DB;

class ReceiveBooksService
{
	public static function update($id, $updateData)
	{
		ReceiveBooksRepository::update($id, $updateData);
	}

	public static function getPageCount($filter)
	{
		$pageCount = ReceiveBooksRepository::getPageCount($filter)/9;
		//無條件進位
        return ceil($pageCount);
	}
	
	public static function getBooksData($filter = 1, $page, $limit)
	{
		$data = ReceiveBooksRepository::getBooksData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}