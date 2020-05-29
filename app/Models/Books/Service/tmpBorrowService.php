<?php
namespace App\Models\Books\Service;

use \App\Models\Books\Repository\tmpBorrowRepository as tmpBorrowRepository;
use Auth;
use DB;

class tmpBorrowService
{
	public static function update($filter, $updateData)
	{
		try {
			DB::beginTransaction();

			tmpBorrowRepository::update($filter, $updateData);

			DB::commit();

		}catch(Exception $e){
            DB::rollback();
        } 
	}

	public static function delete($id)
	{
		try {
			DB::beginTransaction();

			tmpBorrowRepository::delete($id);

			DB::commit();

		}catch(Exception $e){
            DB::rollback();
        } 
	}

	public static function getTmpBorrow($filter)
	{
		$data = tmpBorrowRepository::getTmpBorrow($filter);
		$data = json_decode(json_encode($data), true);

		return $data;
	}
}