<?php
namespace App\Models\Books\Service;

use \App\Models\Books\Repository\SubscriptionBooksRepository as SubscriptionBooksRepository;
use Auth;
use DB;

class SubScriptionBooksService
{
    public static function update($id, $updateData)
    {
        SubscriptionBooksRepository::update($id, $updateData);
    }
    
	public static function getPageCount($filter)
    {
        return SubscriptionBooksRepository::getPageCount($filter)/9;
        //無條件進位
        return ceil($pageCount);
    }

    public static function getBooksData($filter = 1, $page, $limit)
    {
        $data =  SubscriptionBooksRepository::getBooksData($filter, $page, $limit);
        return json_decode(json_encode($data), true);
    }

    public static function getSubBooksCountData()
    {
    	$data = SubscriptionBooksRepository::getSubBooksCountData();
    	$data =  json_decode(json_encode($data),true);

    	foreach($data as &$item) {
        	$item['status'] = ($item['status']=='process') ? '處理中' : '已領取';
        }
        unset($item);

        return $data;
    }
}