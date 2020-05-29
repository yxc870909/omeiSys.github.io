<?php
namespace App\Models\Books\Repository;

use \App\Models\Books\Entity\SubApplication as SubApplication;
use Auth;
use DB;

class SubApplicationRepository
{
	public static function getApplicationData()
	{
		return DB::table('sub_application as sp')
        				->join('temple as t', 'sp.area', '=', 't.area')
        				->join('subscription_books as sb', 'sp.sbid', '=', 'sb.id')
        				->join('set_subscription_count as sc', 'sp.set_id', '=', 'sc.id')
        				->leftJoin('temple_receive as tr', function($join) {
        					$join->on('sp.id', '=', 'tr.spid')
        						 ->on('t.id', '=', 'tr.tid');
        				})
        				->join('category as c', 'sb.cat', '=', 'c.value')
        				->where('sp.status', '=', 'finish')
        				->where('sc.year', '=', date('Y'))
        				->select(
        					'sp.id as spid',
                                                'sp.status',
                                                'sp.area',
        					'sb.id as sbid',
                                                'sb.cat', 
                                                'sb.title',
                                                'sb.img',
                                                'sb.author',
                                                'sb.isbn',
                                                'sb.lan',
                                                'sb.pub_year',
                                                'sb.version',
                                                'sb.no', 
                                                'c.attribute',
                                                'c.word',
                                                't.id as tid',
        				  	DB::Raw('case when tr.count>0 then "disabled" else "" end as disabled'),
        				  	DB::Raw('case when tr.count>0 then tr.count else "" end as count'))
        				->get();
	}
}