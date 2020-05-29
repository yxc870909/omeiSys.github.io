<?php
namespace App\Models\Books\Repository;

use \App\Models\Books\Entity\Books as Books;
use \App\Models\Books\Entity\BorrowBooks as BorrowBooks;
use \App\Models\Books\Entity\SubscriptionBooks as SubscriptionBooks;
use \App\Models\Category\Repository\CategoryRepository as CategoryRepository;
use Auth;
use DB;

class BooksRepository
{

    public static function update($id, $updateData)
    {
        Books::where('id', '=', $id)->update($updateData);
    }

	public static function getPageCount($filter)
	{
		return Books::whereRaw(DB::Raw($filter))->get()->count();
	}

	public static function getBorrowPageCount($filter)
	{
		return BorrowBooks::whereRaw(DB::Raw($filter))->get()->count();
	}

	public static function getBooksData($filter = 1, $page, $limit)
	{
        return DB::table('books as b')
                      ->leftJoin('temple as t', 'b.tid', '=', 't.id')
                      ->leftJoin('category as c', 'b.cat', '=', 'c.value')
                      ->leftJoin('borrow_books as bb', 'b.id', '=', 'bb.bbid')
                      ->whereRaw(DB::Raw($filter))
                      ->groupBy('b.id')
                      ->select('b.*')
                      ->skip(($page-1) * $limit)
                      ->take($limit)
                      ->orderBy('b.id', 'desc')
                      ->select('b.*', 
                                't.name', 'c.type', 'c.value', 'c.word', 'c.order', 'c.attribute', 
                                DB::Raw('case when bb.count>0 then bb.count else 0 end as `out`'))
                      ->get();
	}

	public static function getBorrowBooksData($filter = 1, $page, $limit)
	{
		return DB::table('borrow_books as a')
						->join('books as b', 'a.bbid', '=', 'b.id')
						->join('user as c', 'a.upid', '=', 'c.id')
						->skip(($page-1) * $limit)
						->take($limit)
						->orderBy('a.created_at', 'desc')
						->select('a.id' ,'a.count', 'a.status', 'b.title', 'c.first_name', 'c.last_name')
						->get();
	}

	public static function addBooksNumber($type, $country, $cat)
	{
		$typeNumber = CategoryRepositoryy::where('type', '=', 'library_books_type')
    	                                   ->where('value', '=', $cat)
    	                                   ->get()[0]['attribute'];
    	$res = DB::table('books')
    	            ->where('number', 'like', '%'.$type.$country.$typeNumber.'%')
    	            ->orderBy('number', 'desc')
    	            ->take(1)->first();
    	
    	$number = '';
    	if(count($res) > 0) {
    		
    	}
    	switch($type) {
    		case 'F':
    		case 'L':
    		case 'M':
    		if(count($res) > 0) {
    			$number = substr($res->number, 1);
    			$number = str_pad((int)$number+1, 7, '0', STR_PAD_LEFT);
    		}
    		else 
    			$number = str_pad(1, 7, '0', STR_PAD_LEFT);
    		break;
    		case 'A':
    		case 'B':
    		case 'C':
    		case 'D':
    		case 'E':
    		case 'I':
    		case 'K':
    		if(count($res) > 0) {
    			$number = substr($res->number, 2);
    			$number = str_pad($number, 6, '0', STR_PAD_LEFT);
    		}
    		else
    			$number = str_pad(1, 6, '0', STR_PAD_LEFT);
    		break;
    		case 'J':
    		if(count($res) > 0) {
    			$number = substr($res->number, 3);
    			$number = str_pad((int)$number+1, 5, '0', STR_PAD_LEFT);
    		}
    		else
    			$number = str_pad(1, 5, '0', STR_PAD_LEFT);
    		break;
    		case 'N':
    		if(count($res) > 0) {
    			$number = substr($res->number, 5);
    			$number = str_pad((int)$number+1, 3, '0', STR_PAD_LEFT);
    		}
    		else
    			$number = str_pad(1, 3, '0', STR_PAD_LEFT);
    		break;
    		case 'H':
    		if(count($res) > 0) {
    			$number = substr($res->number, 6);
    			$number = str_pad((int)$number+1, 2, '0', STR_PAD_LEFT);
    		}
    		else
    			$number = str_pad((int)$number+1, 2, '0', STR_PAD_LEFT);
    		break;
    	}
    	
    	return $type.$country.$typeNumber.$number;
	}
}