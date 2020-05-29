<?php
namespace App\Models\Books\Repository;

use \App\Models\Books\Entity\tmpBorrow as tmpBorrow;
use Auth;
use DB;

class tmpBorrowRepository
{
	public static function update($filter, $updateData)
	{
		tmpBorrow::whereRaw($filter)->update($updateData);
	}

	public static function delete($id)
	{
		tmpBorrow::where('id', '=', $id)->delete();
	}

	public static function getTmpBorrow($filter)
	{
		return DB::table('tmp_borrow as t')
				->join('books as b', 't.bid', '=', 'b.id')
				->join('user as u', 't.upid', '=', 'u.id')
				->whereRaw('t.upid', '=', $upid)
				->select('t.id',
						 't.bid',
						 'b.title', 
						 DB::Raw('concat(u.first_name,u.last_name) as name'),
						 't.count')
				->get();
	}
}