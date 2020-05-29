<?php
namespace App\Models\Agenda\Repository;

use \App\Models\Agenda\Entity\Agenda as Agenda;
use Auth;
use DB;
use View;

class AgendaRepository
{
	public static function getPageCount($filter = 1, $type = '', $val = '')
	{
		if($type == 'member') {
            return DB::table(DB::raw(
                '(select 
                    agenda.id, 
                    agenda.type,
                    temple.area, 
                    temple.name as temple_name,
                    agenda.add_date, 
                    concat(user.first_name,user.last_name) as name, 
                    count(agenda_user.id) as count
                  from agenda 
                  left join user on agenda.Dianchuanshi=user.id 
                  left join temple on agenda.tid=temple.id 
                  left join agenda_user on agenda.id=agenda_user.aid '
                  .'where '.$filter
                  .' group by agenda.id) as a'
                ))
                ->leftJoin('agenda_user as b', 'a.id', '=', 'b.aid')
                ->where('b.name', 'like', '%'.$val.'%')
                ->count();
        }
        else {
            return DB::table('agenda')
                        ->whereRaw($filter)                
                        ->count();
        }
	}

	public static function getDataByMember($filter, $val, $page, $limt)
	{
		return DB::table(DB::raw(
    			'(select 
    				agenda.id, 
    				agenda.type,
    				temple.area, 
    				temple.name as temple_name,
    				agenda.add_date, 
    				concat(user.first_name,user.last_name) as name, 
    				count(agenda_user.id) as count
				  from agenda 
				  left join user on agenda.Dianchuanshi=user.id 
				  left join temple on agenda.tid=temple.id 
				  left join agenda_user on agenda.id=agenda_user.aid '
				  .'where '.$filter
				  .' group by agenda.id) as a'
    			))
    			->leftJoin('agenda_user as b', 'a.id', '=', 'b.aid')
    			->where('b.name', 'like', '%'.$val.'%')
                ->skip(($page-1) * $limit)
                ->take($limit)
    			->select('a.*')
    			->get();
	}

	public static function getAgendaData($filter, $page, $limt)
	{
		return DB::table('agenda')    					
    					->leftJoin('user','agenda.Dianchuanshi','=','user.id')
    					->leftJoin('temple','agenda.tid','=','temple.id')
    					->leftJoin('agenda_user', 'agenda.id','=','agenda_user.aid')
    					->whereRaw($filter)
    					->groupBy('agenda.id')
                        ->skip(($page-1) * $limt)
                        ->take($limt)
    					->select('agenda.*', 
    						     // 'agenda.type',
    							 'temple.area', 
    							 DB::raw('temple.name as temple_name') ,
    							 // 'agenda.add_date', 
    							 DB::raw('concat(user.first_name,user.last_name) as name'), 
    							 DB::raw('count(agenda_user.id) as count'))				
    					->get();
	}
}