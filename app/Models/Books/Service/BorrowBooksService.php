<?php
namespace App\Models\Books\Service;

use \App\Models\Books\Repository\BorrowBooksRepository as BorrowBooksRepository;
use \App\Models\Books\Service\tmpBorrowService as tmpBorrowService;
use \App\Models\Books\Service\BooksService as BooksService;
use Auth;
use DB;

class BorrowBooksService
{
	public static function update($id, $updateData)
	{
		BorrowBooksRepository::update($id, $updateData);
	}

	public static function getBorrowBooksData($filter = 1, $page, $limit)
	{
		$data = BorrowBooksRepository::getBorrowBooksData($filter, $page, $limit);
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
	
	public static function getRecordData($filter = 1, $page, $limit)
	{
		$data = BorrowBooksRepository::getRecordData($filter, $page, $limit);
		$data = json_decode(json_encode($data), true);

		return $data;
	}

	public static function AddBorrow($request)
	{
		foreach($request['data'] as $data)
		{
			$res = BooksService::getBooksData('b.id='.$data['bbid'], 1, 1);
			$b_count = json_decode(json_encode($res),true)[0]['count'];
			$new_count = $b_count-$data['count'];

			try {
				DB::beginTransaction();

				$tmp = new \App\Models\Books\Entity\tmpBorrow;
				$tmp->upid = $data['upid'];
				$tmp->bid = $data['bbid'];
				$tmp->count = 1;
				$tmp->save();

				DB::commit();

			}catch(Exception $e){
	            DB::rollback();
	        }  
			tmpBorrowService::delete($data['id']);
			BooksService::update('bb.id='.$data['bbid'], array('count'=>$new_count));
		}
	}
}