<?php
namespace App\Models\Books\Repository;

use \App\Models\Books\Entity\ReceiveBooks as ReceiveBooks;
use DB;

class ReceiveBooksRepository
{
	public static function update($id, $updateData)
    {
        ReceiveBooks::where('id', '=', $id)->update($updateData);
    }
    
	public static function getPageCount($filter)
	{
		return ReceiveBooks::whereRaw(DB::Raw($filter))->get()->count();
	}
	
	public static function getBooksData($filter = 1, $page, $limit)
	{
		return DB::table('receive_books as b')
					->join('category as c', 'b.cat', '=', 'c.value')
					->leftJoin('temple as t', 'b.tid', '=', 't.id')
					->whereRaw($filter)
					->skip(($page-1) * $limit)
					->take($limit)
					->orderBy('b.created_at', 'desc')
					->select('b.*', 'c.type', 'c.value', 'c.word', 'c.order', 'c.attribute', 't.name')
					->get();
	}
}