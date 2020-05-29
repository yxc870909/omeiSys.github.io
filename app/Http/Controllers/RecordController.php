<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

//use App\Http\Requests;
use Request;
use DB;
use \App\Models\User\Entity\User as User;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Agenda\Entity\Agenda as Agenda;
use \App\Models\Agenda\Entity\AgendaUser as AgendaUser;
use \App\Models\Category\Service\CategoryService as Category;
use \App\Models\Activity\Entity\Activity as Activity;
use \App\Repository\Activity as RepositoryActivity;
use \App\Models\Group\Entity\Group as Group;
use \App\Support\Menu as Menu;

class RecordController extends Controller
{
    public function RecordAgendaView(Request $request) {
    	$request = $request::all();
    	$tabTitle = '法會參班紀錄';

    	if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

    	$res = DB::table('agenda_user as au')
    				->join('agenda as a', 'au.aid', '=', 'a.id')
    				->join('temple as t', 'a.tid', '=', 't.id')
    				->where('au.upid', '=', $request['upid'])
    				->where('a.add_date', '>=', $request['year'].'-01-01')
    				->where('a.add_date', '<=', $request['year'].'-12-31')
    				->groupBy('a.id')
    				->orderBy('a.add_date', 'desc')
    				->select('a.id', 't.name', 'a.preside', 'a.type', 'course_title', 'course_lecturer', 'song_title', 'song_lecturer', 'add_date')
    				->get();

    	$years = DB::table('agenda_user as au')
    				->join('agenda as a', 'au.aid', '=', 'a.id')
    				->where('au.upid', '=', $request['upid'])
    				->where(DB::Raw('substr(add_date, 1,4)'), '!=', '0000')
    				->groupBy(DB::Raw('substr(add_date, 1, 4)'))
    				->orderBy('a.add_date', 'desc')
    				->select(DB::Raw('substr(add_date, 1, 4) as year'))
    				->get();

        
    	$year = array(
    		'word'=>$y, 
    		'data'=>array());
    	foreach($years as $item) {
    		array_push($year['data'], array(
    			'active'=>$item->year==date('Y') ? 'active' : '',
    			'value'=>$item->year,
    			'word'=>$item->year
    			));
    	}

    	if(count($year['data']) == 0)
    		array_push($year['data'], array(
    			'active'=>'active',
    			'value'=>date('Y'),
    			'word'=>date('Y')
    			));
	
    	$hash = Category::getHashTable(array('cls_type'));
    	$data = array();
    	foreach($res as $item) {
    		
    		$month = explode('-', $item->add_date)[1];
    		if(!isset($data[$month]))
    			$data[$month] = array();

    		$_preside = json_decode($item->preside);
    		$course_title = json_decode($item->course_title);
    		$song_title = json_decode($item->song_title);
    		$course_lecturer = json_decode($item->course_lecturer);
    		$song_lecturer = json_decode($item->song_lecturer);

    		$preside = array();
    		$course = array();
    		$song = array();
    		foreach($_preside as $v) {
    			$user = User::find($v);
    			$preside[] = $user['first_name'].$user['last_name'];
    		}
    		for($i=0 ; $i < count($course_title); $i++) {
    			$user = User::find($course_lecturer[$i]);
    			$course[] = $user['first_name'].$user['last_name'].' - '. $course_title[$i];
    		}

    		for($i=0 ; $i < count($song_title); $i++) {
    			$user = User::find($song_lecturer[$i]);
    			$song[] = $user['first_name'].$user['last_name'] .' - '. $song_title[$i];
    		}

    		array_push($data[$month], array(
    			'id'=>$item->id,
    			'name'=>$item->name,
    			'preside'=>$preside,
    			'type'=>$hash['cls_type'][$item->type]['word'],
    			'course'=>$course,
    			'song'=>$song,
    			'date'=>explode('-', $item->add_date)[2],
    			));
    	}

    	return view('BKRecordAgenda')->with('menu', Menu::setMenuList(''))
    								->with('userInfo', UserService::getUserBoxInfo())
    								->with('tabTitle', $tabTitle)
    								->with('data', $data)
    								->with('year', $year)
    								->with('upid', $request['upid']);
    }

    public function RecordJoinView(Request $request) {
    	$request = $request::all();
    	$tabTitle = '班程參班紀錄';

    	if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

        $res = DB::table('activity_user as au')
    				->join('activity as a', 'au.aid', '=', 'a.id')
    				->join('temple as t', 'a.tid', '=', 't.id')
    				->where('au.upid', '=', $request['upid'])
    				->where('a.add_date', '>=', $request['year'].'-01-01')
    				->where('a.add_date', '<=', $request['year'].'-12-31')
    				->groupBy('a.id')
    				->orderBy('a.add_date', 'desc')
    				->select('a.id', 't.name', 'a.preside', 'a.type', 'course_title', 'course_lecturer', 'song_title', 'song_lecturer', 'add_date')
    				->get();

    	$years = DB::table('activity_user as au')
    				->join('activity as a', 'au.aid', '=', 'a.id')
    				->where('au.upid', '=', $request['upid'])
    				->where(DB::Raw('substr(add_date, 1,4)'), '!=', '0000')
    				->groupBy(DB::Raw('substr(add_date, 1, 4)'))
    				->orderBy('a.add_date', 'desc')
    				->select(DB::Raw('substr(add_date, 1, 4) as year'))
    				->get();
    	
    	$year = array(
    		'word'=>$y, 
    		'data'=>array());
    	foreach($years as $item) {
    		array_push($year['data'], array(
    			'active'=>$item->year==date('Y') ? 'active' : '',
    			'value'=>$item->year,
    			'word'=>$item->year
    			));
    	}

    	if(count($year['data']) == 0)
    		array_push($year['data'], array(
    			'active'=>'active',
    			'value'=>date('Y'),
    			'word'=>date('Y')
    			));

    	$data = array();
    	foreach($res as $item) {
    		
    		$month = explode('-', $item->add_date)[1];
    		if(!isset($data[$month]))
    			$data[$month] = array();

    		$_preside = json_decode($item->preside);
    		$course_title = json_decode($item->course_title);
    		$song_title = json_decode($item->song_title);
    		$course_lecturer = json_decode($item->course_lecturer);
    		$song_lecturer = json_decode($item->song_lecturer);

    		$preside = array();
    		$course = array();
    		$song = array();
    		foreach($_preside as $v) {
    			$user = User::find($v);
    			$preside[] = $user['first_name'].$user['last_name'];
    		}
    		for($i=0 ; $i < count($course_title); $i++) {
    			$user = User::find($course_lecturer[$i]);
    			$course[] = $user['first_name'].$user['last_name'].' - '. $course_title[$i];
    		}

    		for($i=0 ; $i < count($song_title); $i++) {
    			$user = User::find($song_lecturer[$i]);
    			$song[] = $user['first_name'].$user['last_name'] .' - '. $song_title[$i];
    		}

    		array_push($data[$month], array(
    			'id'=>$item->id,
    			'name'=>$item->name,
    			'preside'=>$preside,
    			'type'=>$item->type,
    			'course'=>$course,
    			'song'=>$song,
    			'date'=>explode('-', $item->add_date)[2],
    			));
    	}

    	return view('BKRecordJoin')->with('menu', Menu::setMenuList(''))
    								->with('userInfo', UserService::getUserBoxInfo())
    								->with('tabTitle', $tabTitle)
    								->with('data', $data)
    								->with('year', $year)
    								->with('upid', $request['upid']);
    }

    public function RecorGroupView(Request $request) {
    	$request = $request::all();
    	$tabTitle = '團隊辦事紀錄';

    	$Previous = '';
        $Next = '';
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;

    	$res = Group::where('upid', $request['upid'])
    			->orderBy('created_at', 'desc')
    			->orderBy('year', 'desc')
    			->orderBy('area', 'desc')
    			->orderBy('group', 'desc')
    			->orderBy(DB::Raw("FIELD('type', 'leader', 'deputy_leader', 'member')"))
    			->skip(($request['page']-1) * 15)
                ->take(15)
    			->get();

    	$hash = Category::getHashTable(array('area', 'group', 'group_type'));

    	$data = array();
    	foreach($res as $item) {
    		array_push($data, array(
    			'year'=>$item['year'],
    			'area'=>$hash['area'][$item['area']]['word'],
    			'group'=>$hash['group'][$item['group']]['word'],
    			'type'=>$hash['group_type'][$item['type']]['word'],
    			));
    	}

    	$pageCount = Group::where('upid', $request['upid'])->count()/10;

    	$pageCount = ceil($pageCount);

        if($request['page'] == 1)
            $Previous = 'disabled';
        if($request['page'] == $pageCount)
            $Next = 'disabled';

        $page = array();
        for($i=0; $i<$pageCount; $i++) {
            $active = $request['page']==($i+1) ? 'active' : '';
            array_push($page, array(
                'link'=>'/RecorGroup?upid='.$request['upid'].
                        'page='.$request['page'],
                'count'=>$i+1,
                'active'=>$active
                ));
        }



    	return view('BKRecordGroup')->with('menu', Menu::setMenuList(''))
    								->with('userInfo', UserService::getUserBoxInfo())
    								->with('tabTitle', $tabTitle)
    								->with('data', $data)

    								->with('page', $page)
		                            ->with('pageCount', $pageCount)
		                            ->with('Previous', $Previous)
		                            ->with('Next', $Next);
    }

    public function RecordActivityView(Request $request) {
    	$request = $request::all();

    	$tabs = array(
    		array('active'=>'active', 'link'=>'#agenda', 'val'=>'agenda', 'word'=>'法會辦事紀錄'),
    		array('active'=>'', 'link'=>'#regist', 'val'=>'regist', 'word'=>'掛號辦事紀錄'),
    		);

    	if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

        $agendas = DB::table('agenda as a')
        		->join('temple as t', 'a.tid', '=', 't.id')
        		->join('category as c', 'a.type', '=', 'c.value')
        		->orWhere('Dianchuanshi', '=', $request['upid'])
        		->orWhere('Dianchuanshi2', '=', $request['upid'])
        		->orWhere('preside', '=', $request['upid'])
        		->orWhere('upper', '=', $request['upid'])
        		->orWhere('lowwer', '=', $request['upid'])

        		->orWhere('action', 'like', '['.$request['upid'].',%')
        		->orWhere('action', 'like', '%,'.$request['upid'].',%')
        		->orWhere('action', 'like', '%,'.$request['upid'].']')

        		->orWhere('support', 'like', '['.$request['upid'].',%')
        		->orWhere('support', 'like', '%,'.$request['upid'].',%')
        		->orWhere('support', 'like', '%,'.$request['upid'].']')

        		->orWhere('counseling', 'like', '['.$request['upid'].',%')
        		->orWhere('counseling', 'like', '%,'.$request['upid'].',%')
        		->orWhere('counseling', 'like', '%,'.$request['upid'].']')

        		->orWhere('write', 'like', '['.$request['upid'].',%')
        		->orWhere('write', 'like', '%,'.$request['upid'].',%')
        		->orWhere('write', 'like', '%,'.$request['upid'].']')

        		->orWhere('towel', 'like', '['.$request['upid'].',%')
        		->orWhere('towel', 'like', '%,'.$request['upid'].',%')
        		->orWhere('towel', 'like', '%,'.$request['upid'].']')

        		->orWhere('music', 'like', '['.$request['upid'].',%')
        		->orWhere('music', 'like', '%,'.$request['upid'].',%')
        		->orWhere('music', 'like', '%,'.$request['upid'].']')

        		->orWhere('service1', 'like', '['.$request['upid'].',%')
        		->orWhere('service1', 'like', '%,'.$request['upid'].',%')
        		->orWhere('service1', 'like', '%,'.$request['upid'].']')

        		->orWhere('traffic', 'like', '['.$request['upid'].',%')
        		->orWhere('traffic', 'like', '%,'.$request['upid'].',%')
        		->orWhere('traffic', 'like', '%,'.$request['upid'].']')

        		->orWhere('affairs', 'like', '['.$request['upid'].',%')
        		->orWhere('affairs', 'like', '%,'.$request['upid'].',%')
        		->orWhere('affairs', 'like', '%,'.$request['upid'].']')

        		->orWhere('cooker', 'like', '['.$request['upid'].',%')
        		->orWhere('cooker', 'like', '%,'.$request['upid'].',%')
        		->orWhere('cooker', 'like', '%,'.$request['upid'].']')

        		->orWhere('uplow', '=', $request['upid'])

        		->orWhere('sambo', 'like', '['.$request['upid'].',%')
        		->orWhere('sambo', 'like', '%,'.$request['upid'].',%')
        		->orWhere('sambo', 'like', '%,'.$request['upid'].']')

        		->orWhere('add', '=', $request['upid'])
        		->orWhere('aegis', '=', $request['upid'])

        		->orWhere('flower', 'like', '['.$request['upid'].',%')
        		->orWhere('flower', 'like', '%,'.$request['upid'].',%')
        		->orWhere('flower', 'like', '%,'.$request['upid'].']')

        		->orWhere('accounting', 'like', '['.$request['upid'].',%')
        		->orWhere('accounting', 'like', '%,'.$request['upid'].',%')
        		->orWhere('accounting', 'like', '%,'.$request['upid'].']')
        		->orderBy('a.add_date', 'desc')
        		->select('a.id', 't.name', 'a.preside', 'c.word as type', 'course_title', 'course_lecturer', 'song_title', 'song_lecturer', 'add_date')
        		->get();


        
    	$year1 = array('word'=>$y, 'data'=>array());
    	$data1 = array();
    	foreach($agendas as $item) {

			$Y = explode('-', $item->add_date)[0];
    		$month = explode('-', $item->add_date)[1];

    		if(RecordController::issetYear($year1['data'], $Y))
	    		array_push($year1['data'], array(
	    			'active'=>$Y==$y ? 'active' : '',
	    			'value'=>$Y,
	    			'word'=>$Y
	    			));

    		if($Y == $y) {

    			if(!isset($data[$month]))
    			$data1[$month] = array();

	    		$_preside = json_decode($item->preside);
	    		$course_title = json_decode($item->course_title);
	    		$song_title = json_decode($item->song_title);
	    		$course_lecturer = json_decode($item->course_lecturer);
	    		$song_lecturer = json_decode($item->song_lecturer);

	    		$preside = array();
	    		$course = array();
	    		$song = array();
	    		foreach($_preside as $v) {
	    			$user = User::find($v);
	    			$preside[] = $user['first_name'].$user['last_name'];
	    		}
	    		for($i=0 ; $i < count($course_title); $i++) {
	    			$user = User::find($course_lecturer[$i]);
	    			$course[] = $user['first_name'].$user['last_name'].' - '. $course_title[$i];
	    		}

	    		for($i=0 ; $i < count($song_title); $i++) {
	    			$user = User::find($song_lecturer[$i]);
	    			$song[] = $user['first_name'].$user['last_name'] .' - '. $song_title[$i];
	    		}

	    		array_push($data1[$month], array(
	    			'id'=>$item->id,
	    			'name'=>$item->name,
	    			'preside'=>$preside,
	    			'type'=>$item->type,
	    			'course'=>$course,
	    			'song'=>$song,
	    			'date'=>explode('-', $item->add_date)[2],
	    			));
    		}
    		
    	}

    	if(count($year1['data']) == 0)
	    	array_push($year1['data'], array(
	    		'active'=>'active',
	    		'value'=>date('Y'),
	    		'word'=>date('Y')
	    		));



    	$regist = DB::table('regist as a')
        				->join('temple as t', 'a.tid', '=', 't.id')
        				->join('user as u', 'a.id', '=', 'u.regist_id')
        				->orWhere('upper', '=', $request['upid'])
        				->orWhere('lowwer', '=', $request['upid'])

        				->orWhere('action', 'like', '['.$request['upid'].',%')
        				->orWhere('action', 'like', '%,'.$request['upid'].',%')
        				->orWhere('action', 'like', '%,'.$request['upid'].']')

        				->orWhere('support', 'like', '['.$request['upid'].',%')
        				->orWhere('support', 'like', '%,'.$request['upid'].',%')
        				->orWhere('support', 'like', '%,'.$request['upid'].']')

        				->orWhere('service1', 'like', '['.$request['upid'].',%')
        				->orWhere('service1', 'like', '%,'.$request['upid'].',%')
        				->orWhere('service1', 'like', '%,'.$request['upid'].']')

        				->orWhere('service2', 'like', '['.$request['upid'].',%')
        				->orWhere('service2', 'like', '%,'.$request['upid'].',%')
        				->orWhere('service2', 'like', '%,'.$request['upid'].']')

        				->orWhere('towel', 'like', '['.$request['upid'].',%')
        				->orWhere('towel', 'like', '%,'.$request['upid'].',%')
        				->orWhere('towel', 'like', '%,'.$request['upid'].']')

        				->orWhere('traffic', 'like', '['.$request['upid'].',%')
        				->orWhere('traffic', 'like', '%,'.$request['upid'].',%')
        				->orWhere('traffic', 'like', '%,'.$request['upid'].']')

        				->orWhere('cooker', 'like', '['.$request['upid'].',%')
        				->orWhere('cooker', 'like', '%,'.$request['upid'].',%')
        				->orWhere('cooker', 'like', '%,'.$request['upid'].']')

        				->orWhere('sambo', 'like', '['.$request['upid'].',%')
        				->orWhere('sambo', 'like', '%,'.$request['upid'].',%')
        				->orWhere('sambo', 'like', '%,'.$request['upid'].']')

        				->orWhere('Introduction', 'like', '['.$request['upid'].',%')
        				->orWhere('Introduction', 'like', '%,'.$request['upid'].',%')
        				->orWhere('Introduction', 'like', '%,'.$request['upid'].']')

        				->orWhere('preside', 'like', '['.$request['upid'].',%')
        				->orWhere('preside', 'like', '%,'.$request['upid'].',%')
        				->orWhere('preside', 'like', '%,'.$request['upid'].']')

        				->orWhere('uplow', '=', $request['upid'])
        				->orWhere('add', '=', $request['upid'])
        				->orWhere('translation', '=', $request['upid'])
        				->orWhere('peper', '=', $request['upid'])
        				->orWhere('aegis', '=', $request['upid'])
        				->groupBy('a.id')
        				->orderBy('a.add_date', 'desc')
        				->select('a.id','t.name', DB::Raw('count(u.id) as count'), 'a.add_date')
        				->get();
        
        $year2 = array('word'=>$y, 'data'=>array());
    	$data2 = array();
    	foreach($regist as $item) {

			$Y = explode('-', $item->add_date)[0];
    		$month = explode('-', $item->add_date)[1];

    		if(RecordController::issetYear($year2['data'], $Y))
	    		array_push($year2['data'], array(
	    			'active'=>$Y==$y ? 'active' : '',
	    			'value'=>$Y,
	    			'word'=>$Y
	    			));

    		if($Y == $y) {

    			if(!isset($data[$month]))
    			$data2[$month] = array();

	    		array_push($data2[$month], array(
	    			'id'=>$item->id,
	    			'name'=>$item->name,
	    			'count'=>$item->count,
	    			'date'=>explode('-', $item->add_date)[2],
	    			));
    		}
    		
    	}

    	if(count($year2['data']) == 0)
	    	array_push($year2['data'], array(
	    		'active'=>'active',
	    		'value'=>date('Y'),
	    		'word'=>date('Y')
	    		));

    	return view('BKRecordActivity')->with('menu', Menu::setMenuList(''))
    								->with('userInfo', UserService::getUserBoxInfo())
    								->with('data1', $data1)
    								->with('tabs', $tabs)
    								->with('year1', $year1)

    								->with('data2', $data2)
    								->with('year2', $year2)
    								->with('upid', $request['upid']);
    }

    public function RecordTeatchView(Request $request) {
    	$request = $request::all();
    	$tabs = array(
    		array('active'=>'active', 'link'=>'#agenda', 'val'=>'agenda', 'word'=>'授課紀錄')
    		);

    	if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

    	$agendas = DB::table('agenda as a')
        		->join('temple as t', 'a.tid', '=', 't.id')
        		->join('category as c', 'a.type', '=', 'c.value')
        		->orWhere('course_lecturer', 'like', '['.$request['upid'].',%')
        		->orWhere('course_lecturer', 'like', '%,'.$request['upid'].',%')
        		->orWhere('course_lecturer', 'like', '%,'.$request['upid'].']')

        		->orWhere('song_lecturer', 'like', '['.$request['upid'].',%')
        		->orWhere('song_lecturer', 'like', '%,'.$request['upid'].',%')
        		->orWhere('song_lecturer', 'like', '%,'.$request['upid'].']')
        		->select('a.id', 't.name', 'a.preside', 'c.word as type', 'course_title', 'course_lecturer', 'song_title', 'song_lecturer', 'add_date');
        		//->get();

        $activity = DB::table('activity as a')
        		->join('temple as t', 'a.tid', '=', 't.id')
        		->orWhere('course_lecturer', 'like', '['.$request['upid'].',%')
        		->orWhere('course_lecturer', 'like', '%,'.$request['upid'].',%')
        		->orWhere('course_lecturer', 'like', '%,'.$request['upid'].']')

        		->orWhere('song_lecturer', 'like', '['.$request['upid'].',%')
        		->orWhere('song_lecturer', 'like', '%,'.$request['upid'].',%')
        		->orWhere('song_lecturer', 'like', '%,'.$request['upid'].']')
        		->select('a.id', 't.name', 'a.preside', 'a.type', 'course_title', 'course_lecturer', 'song_title', 'song_lecturer', 'add_date')
        		->union($agendas)
        		->orderBy('add_date', 'desc')
        		->get();

        $res = $activity;

        $year = array('word'=>$y, 'data'=>array());
        $data = array();
    	foreach($res as $item) {

    		$Y = explode('-', $item->add_date)[0];
    		$month = explode('-', $item->add_date)[1];

    		if(RecordController::issetYear($year['data'], $Y))
	    		array_push($year['data'], array(
	    			'active'=>$Y==$y ? 'active' : '',
	    			'value'=>$Y,
	    			'word'=>$Y
	    			));

    		if($Y == $y) {
    			$month = explode('-', $item->add_date)[1];
	    		if(!isset($data[$month]))
	    			$data[$month] = array();

	    		$_preside = json_decode($item->preside);
	    		$course_title = json_decode($item->course_title);
	    		$song_title = json_decode($item->song_title);
	    		$course_lecturer = json_decode($item->course_lecturer);
	    		$song_lecturer = json_decode($item->song_lecturer);

	    		$preside = array();
	    		$course = array();
	    		$song = array();
	    		foreach($_preside as $v) {
	    			$user = User::find($v);
	    			$preside[] = $user['first_name'].$user['last_name'];
	    		}
	    		for($i=0 ; $i < count($course_title); $i++) {
	    			$user = User::find($course_lecturer[$i]);
	    			$course[] = $user['first_name'].$user['last_name'].' - '. $course_title[$i];
	    		}

	    		for($i=0 ; $i < count($song_title); $i++) {
	    			$user = User::find($song_lecturer[$i]);
	    			$song[] = $user['first_name'].$user['last_name'] .' - '. $song_title[$i];
	    		}

	    		array_push($data[$month], array(
	    			'id'=>$item->id,
	    			'name'=>$item->name,
	    			'preside'=>$preside,
	    			'type'=>$item->type,
	    			'course'=>$course,
	    			'song'=>$song,
	    			'date'=>explode('-', $item->add_date)[2],
	    			));
    		}
    	}

    	if(count($year['data']) == 0)
	    	array_push($year['data'], array(
	    		'active'=>'active',
	    		'value'=>date('Y'),
	    		'word'=>date('Y')
	    		));
        

    	return view('BKRecordTeatch')->with('menu', Menu::setMenuList(''))
    								->with('userInfo', UserService::getUserBoxInfo())
    								->with('tabs', $tabs)
    								->with('data', $data)
    								->with('year', $year)
    								->with('upid', $request['upid']);
    }

    public function RecordIntroducerView(Request $request) {
        $request = $request::all();
        if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

        $res = DB::table('user as u')
                ->join('regist as r', 'u.regist_id', '=', 'r.id')
                ->join('temple as t', 'r.tid', '=', 't.id')
                ->where('Introducer', '=', $request['upid'])                
                ->orderBy('r.add_date', 'desc')
                ->select('u.*', 'r.id', 't.name', 'add_date', 'add_date2')
                ->get();
        
        $year = array('word'=>$y, 'data'=>array());
        $data = array();
        foreach($res as $item) {

            $Y = explode('-', $item->add_date)[0];
            $month = explode('-', $item->add_date)[1];

            if(RecordController::issetYear($year['data'], $Y))
                array_push($year['data'], array(
                    'active'=>$Y==$y ? 'active' : '',
                    'value'=>$Y,
                    'word'=>$Y
                    ));

            if($Y == $y) {

                if(!isset($data[$month]))
                    $data[$month] = array();

                $tmp = explode('-', $item->add_date2);
                $date2 = $item->add_date2 != '' ? $tmp[0].'歲次'.$tmp[1].$tmp[2].$tmp[3].$tmp[4] : '';
                array_push($data[$month], array(
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'date'=>explode('-', $item->add_date)[2],
                    'date2'=>$date2,
                    'users'=>$item->first_name.$item->last_name
                    ));
            }
            
        }

        return view('BKRecordIntroducer')->with('menu', Menu::setMenuList())
                                    ->with('userInfo', UserService::getUserBoxInfo())
                                    ->with('data', $data)
                                    ->with('year', $year)
                                    ->with('upid', $request['upid']);
    }

     public function RecordGuarantorView(Request $request) {
        $request = $request::all();
        if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

        $res = DB::table('user as u')
                ->join('regist as r', 'u.regist_id', '=', 'r.id')
                ->join('temple as t', 'r.tid', '=', 't.id')
                ->where('Guarantor', '=', $request['upid'])                
                ->orderBy('r.add_date', 'desc')
                ->select('u.*', 'r.id', 't.name', 'add_date', 'add_date2')
                ->get();

        $year = array('word'=>$y, 'data'=>array());
        $data = array();
        foreach($res as $item) {

            $Y = explode('-', $item->add_date)[0];
            $month = explode('-', $item->add_date)[1];

            if(RecordController::issetYear($year['data'], $Y))
                array_push($year['data'], array(
                    'active'=>$Y==$y ? 'active' : '',
                    'value'=>$Y,
                    'word'=>$Y
                    ));

            if($Y == $y) {

                if(!isset($data[$month]))
                    $data[$month] = array();

                $tmp = explode('-', $item->add_date2);
                $date2 = $tmp[0].'歲次'.$tmp[1].$tmp[2].$tmp[3].$tmp[4];
                array_push($data[$month], array(
                    'id'=>$item->id,
                    'name'=>$item->name,
                    'date'=>explode('-', $item->add_date)[2],
                    'date2'=>$date2,
                    'users'=>$item->first_name.$item->last_name
                    ));
            }
            
        }

        return view('BKRecordGuarantor')->with('menu', Menu::setMenuList(''))
                                    ->with('userInfo', UserService::getUserBoxInfo())
                                    ->with('data', $data)
                                    ->with('year', $year)
                                    ->with('upid', $request['upid']);
     }

    private function issetYear($data, $y) {

    	$flag = true;
    	foreach($data as $item) {
    		if($item['value']==$y)
    			$flag = false;
    	}

    	return $flag;
    }

}
