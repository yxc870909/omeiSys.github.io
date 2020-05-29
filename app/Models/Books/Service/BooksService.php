<?php
namespace App\Models\Books\Service;

use \App\Models\Books\Repository\BooksRepository as BooksRepository;
use Auth;
use DB;

class BooksService
{
	public static function update($id, $updateData)
	{
		BooksRepository::update($id, $updateData);
	}

	public static function getPageCount($filter)
	{
		$pageCount = BooksRepository::getPageCount($filter)/9;
		//無條件進位
        return ceil($pageCount);
	}

	public static function getBorrowPageCount($filter)
	{
		$pageCount = BooksRepository::getBorrowPageCount($filter)/15;
		//無條件進位
        return ceil($pageCount);
	}

	public static function getSubscriptionPageCount($filter)
	{
		$pageCount = BooksRepository::getSubscriptionPageCount($filter)/9;
		//無條件進位
        return ceil($pageCount);
	}

	public static function getBooksData($filter = 1, $page, $limit)
	{
		$data = BooksRepository::getBooksData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}

	public static function getSubScriptionBooksData($filter = 1, $page, $limit)
	{
		$data = BooksRepository::getSubScriptionBooksData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		foreach($books as &$item) {
			if($item['status'] == 'open') {
				$item['color'] = 'green';
				$item['statusWord'] = '開放申請中';
			}
			if($item['status'] == 'process') {
				$item['color'] = 'red';
				$item['statusWord'] = '結束申請';
			}
			if(count($item['count']) == 0 || $item['public_date']=='0000-00-00') {
				$item['public_date'] = '未定';
			}
		}
		unset($item);

		return $data;
	}

	public static function getBorrowBooksData($filter = 1, $page, $limit)
	{
		$data = BooksRepository::getBorrowBooksData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		foreach($data as &$item) {
			if($item['status'] == 'out') {
				$item['color'] = 'red';
				$item['statusWord'] = '借出';
			}
			if($item['status'] == 'back') {
				$item['color'] = 'green';
				$item['statusWord'] = '歸還';
			}
		}
		unset($item);

		return $data;
	}

	public static function addBooksNumber($type, $country, $cat)
	{
		return BooksRepository::addBooksNumber($type, $country, $cat);
	}
}