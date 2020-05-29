<?php
namespace App\Models\Books\Repository;

use \App\Models\Books\Entity\SubscriptionBooks as SubscriptionBooks;
use Auth;
use DB;

class SubScriptionBooksRepository
{
  public static function update($id, $updateData)
  {
      SubscriptionBooks::where('id', '=', $id)->update($updateData);
  }
    
	public static function getPageCount($filter)
    {
        return SubscriptionBooks::whereRaw($filter)->get()->count();
    }

    public static function getBooksData($filter = 1, $page, $limit)
    {
      return DB::table('subscription_books')
                ->join('category', 'subscription_books.cat', '=', 'category.value')
                ->join('temple', 'subscription_books.tid', '=', 'temple.id')
                ->whereRaw($filter)
                ->skip(($page-1) * $limit)
                ->take($limit)
                ->get();


        return SubscriptionBooks::where('count' , '>', 0)
                                ->whereRaw($filter)
                                // ->where('status', '!=', 'finish')
                                ->skip(($page-1) * $limit)
                                ->take($limit)
                                ->get();
    }

    public static function getSubBooksCountData()
    {
        return DB::table('subscription_books as sb')
                          ->join('sub_application as sp', 'sb.id', '=', 'sp.sbid')
                          ->join('set_subscription_count as sc', 'sp.set_id', '=', 'sc.id')
                          ->join('category as c', 'sb.cat', '=', 'c.value')
                          ->where('sc.year', '=', date('Y'))
                          ->select('sb.id as sbid', 'sp.id as spid', 'sp.area', 'c.attribute', 'sb.cat', 'c.word', 'sb.title', 'sp.status', 'sp.count', 
                              DB::Raw('case when sp.status="process" then "red" else "green" end as color'),
                              DB::Raw('case when sp.status="process" then "" else "disabled" end as disabled'))
                          ->get();
    }
}