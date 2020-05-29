<?php
namespace App\Models\Books\Repository;

use \App\Models\Books\Entity\BorrowBooks as BorrowBooks;
use Auth;
use DB;

class BorrowBooksRepository
{
	public static function update($id, $updateData)
    {
        BorrowBooks::where('id', '=', $id)->update($updateData);
    }

    public static function getBorrowBooksData($filter = 1, $page, $limit)
	{
		return DB::table('borrow_books as a')
						->join('books as b', 'a.bbid', '=', 'b.id')
						->join('user as c', 'a.upid', '=', 'c.id')
						// ->whereRaw(DB::Raw($filter))
						->skip(($page-1) * $limit)
						->take($limit)
						->orderBy('a.created_at', 'desc')
						->select('a.id' ,'a.count', 'a.status', 'b.title', 'c.first_name', 'c.last_name')
						->get();
	}
    
	public static function getRecordData($filter = 1, $page, $limit)
	{
		return DB::table('borrow_books as a')
						->join('books as b', 'a.bbid', '=', 'b.id')
						->join('category as c', 'b.cat', '=', 'c.value')
						->leftJoin('temple as d', 'b.tid', '=', 'd.id')
						// ->where('a.id', '=', $request['id'])
						->whereRaw(DB::Raw($filter))
						->skip(($page-1) * $limit)
                      	->take($limit)
						->select(
							'a.status', 
							'a.return_date',
							'b.cat', 
							'b.title', 
							'b.img',
							'b.author',
							'b.isbn',
							'b.lan',
							'b.pub_year',
							'b.version',
							'b.no', 
							'c.*', 'd.name')
						->get();
	}
}