<?php
namespace App\Models\Books\Repository;

use \App\Models\Books\Entity\RecvApplication as RecvApplication;
use Auth;
use DB;

class RecvApplicationRepository
{
	public static function update($id, $updateData)
    {
        RecvApplication::where('id', '=', $id)->update($updateData);
    }
	
	public static function getPageCount($filter)
	{
		return RecvApplication::whereRaw(DB::Raw($filter))->get()->count();
	}
	
	public static function getApplicationData($filter = 1, $page, $limit)
	{
		return DB::table('recv_application as app')
						->join('receive_books as b', 'app.rbid', '=', 'b.id')
						->join('category as c', 'b.cat', '=', 'c.value')
						->leftJoin('temple as t', 'b.tid', '=', 't.id')
						->join('user as u', 'app.upid', '=', 'u.id')
						->whereRaw(DB::Raw($filter))
						->skip(($page-1) * $limit)
						->take($limit)
						->orderBy('app.created_at', 'desc')
						->select(
							'app.id' ,
							'app.count',
							'app.status', 
							'b.cat', 
							'b.title', 
							'b.img',
							'b.author',
							'b.isbn',
							'b.lan',
							'b.pub_year',
							'b.version',
							'b.no', 
							'u.first_name', 
							'u.last_name',
							'c.type',
							'c.value',
							'c.word',
							'c.order',
							'c.attribute', 
							't.name')
						->get();
	}
}