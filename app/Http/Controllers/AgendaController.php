<?php

namespace App\Http\Controllers;

use \App\Checker\AgendaValidator as AgendaValidator;
use \App\Models\Agenda\Service\AgendaService as AgendaService;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Temple\Service\TempleService as TempleService;
use \App\Models\Category\Service\CategoryService as CategoryService;
use \App\Support\PageSupport as PageSupport;
use \App\Support\LunarDate as LunarDate;
use \App\Support\Menu as Menu;
use Request;
use DB;
use Auth;
use View;

class AgendaController extends Controller
{
    public function doAddAgenda(Request $request)
    {
        $request = $request::all();

        if($request['cls_type'] == 'three')
            $validator = AgendaValidator::AddThreeAgendalValidator($request);
        else
            $validator = AgendaValidator::AddAgendalValidator($request);

        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        try {
            DB::beginTransaction();
            $request['add_date'] = str_replace(array('年','月','日'), array('-','-',''), $request['add_date']);
            $action = isset($request['action']) ? json_encode($request['action']) : '';
            $preside = isset($request['preside']) ? json_encode($request['preside']) : '';
            $support = isset($request['support']) ? json_encode($request['support']) : '';
            $counseling = isset($request['counseling']) ? json_encode($request['counseling']) : '';
            $write = isset($request['write']) ? json_encode($request['write']) : '';
            $towel = isset($request['towel']) ? json_encode($request['towel']) : '';
            $music = isset($request['music']) ? json_encode($request['music']) : '';
            $service1 = isset($request['service1']) ? json_encode($request['service1']) : '';
            $traffic = isset($request['traffic']) ? json_encode($request['traffic']) : '';
            $affairs = isset($request['affairs']) ? json_encode($request['affairs']) : '';
            $cooker = isset($request['cooker']) ? json_encode($request['cooker']) : '';
            $accounting = isset($request['accounting']) ? json_encode($request['accounting']) : '';
            $course_title = isset($request['course_title']) ? json_encode($request['course_title']) : '';
            $course = isset($request['course']) ? json_encode($request['course']) : '';
            $song_title = isset($request['song_title']) ? json_encode($request['song_title']) : '';
            $song = isset($request['song']) ? json_encode($request['song']) : '';

            $agenda = new \App\Models\Agenda\Entity\Agenda;
            $agenda->tid = $request['tid'];
            $agenda->type = $request['cls_type'];
            $agenda->Dianchuanshi = isset($request['aegis']) ? $request['Dianchuanshi'] : '';
            $agenda->Dianchuanshi2 = isset($request['aegis']) ? $request['Dianchuanshi2'] : '';
            $agenda->upper = isset($request['upper']) ? $request['upper'] : '';
            $agenda->lowwer = isset($request['lowwer']) ? $request['lowwer'] : '';
            $agenda->action = $action;
            $agenda->preside = $preside;
            $agenda->support = $support;
            $agenda->counseling = $counseling;
            $agenda->write = $write;      
            $agenda->towel = $towel;                
            $agenda->music = $music;
            $agenda->service1 = $service1;
            $agenda->traffic = $traffic;
            $agenda->affairs = $affairs;
            $agenda->cooker = $cooker;
            $agenda->accounting = $accounting;
            $agenda->course_title = $course_title;
            $agenda->course_lecturer = $course;
            $agenda->song_title = $song_title;
            $agenda->song_lecturer = $song;
            $agenda->sambo = isset($request['sambo']) ? $request['sambo'] : '';
            $agenda->uplow = isset($request['uplow']) ? $request['uplow'] : '';
            $agenda->add = isset($request['add']) ? $request['add'] : '';
            $agenda->aegis = isset($request['aegis']) ? $request['aegis'] : '';
            $agenda->flower = isset($request['flower']) ? $request['flower'] : '';
            $agenda->add_date = $request['add_date'];
            $agenda->add_date2 = $request['yyy'].'年-'.$request['yy'].'-'.$request['mm'].'-'.$request['dd'];
            $agenda->save();

            DB::commit();

            $last_id = \App\Models\Agenda\Entity\Agenda::orderBy('id','asc')->take(1)->first();

            DB::beginTransaction();
            for($i=0; $i<count($request['name']); $i++) {
                $a_user = new \App\Models\Agenda\Entity\AgendaUser;
                $a_user->aid = $last_id;
                $a_user->name = $request['name'][$i];
                $a_user->inDB = $request['inDB'][$i];
                $a_user->app = $request['app'][$i];
                $a_user->gender = $request['gender'][$i];
                $a_user->Introducer = $request['Introducer'][$i];
                $a_user->Guarantor = $request['Guarantor'][$i];
                $a_user->year = $request['year'][$i];
                $a_user->temple = isset($request['other_temple'][$i]) ? $request['other_temple'][$i] : 0;
                $a_user->mobile = $request['mobile'][$i];
                $a_user->phone = $request['phone'][$i];
                $a_user->edu = $request['edu'][$i];
                $a_user->skill = $request['skill'][$i]; 
                $a_user->addr = $request['addr'][$i];
                $a_user->remark = $request['remark'][$i];
                $a_user->save();
            }
            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e) {
            DB::rollback();
            echo json_encode($e);
            exit();
        }

        echo json_encode($request);
        exit();




    	\App\Models\Entity\Agenda::doAddAgenda($request::all());
    }

    public function doGetAgenda(Request $request)
    {
        $request = $request::all();

        $res = AgendaService::getAgendaData('agenda.id='.$request['id'], 1, 9999)[0];
        
        $_preside = json_decode($res['preside']);
        $course_title = json_decode($res['course_title']);
        $song_title = json_decode($res['song_title']);
        $course_lecturer = json_decode($res['course_lecturer']);
        $song_lecturer = json_decode($res['song_lecturer']);

        $preside = array();
        $course = array();
        $song = array();
        foreach($_preside as $v) {
            if($v > 0) {
                $user = UserService::find($v);
                $preside[] = $user['first_name'].$user['last_name'];
            }
        }
        for($i=0 ; $i < count($course_title); $i++) {
            $user = UserService::find(1, 'a.id='.$course_lecturer[$i], 9999, 1)[0];
            $course[] = $user['first_name'].$user['last_name'].' - '. $course_title[$i];
        }

        for($i=0 ; $i < count($song_title); $i++) {
            $user = UserService::find(1, 'a.id='.$song_lecturer[$i], 9999, 1)[0];
            $song[] = $user['first_name'].$user['last_name'] .' - '. $song_title[$i];
        }

        $data = array();
        $data['name'] = $res['temple_name'];
        $data['preside'] = $preside;
        $data['course'] = $course;
        $data['song'] = $song;

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function AgendaView(Request $request)
    {
        $request = $request::all();

        $type = array(
            'Dianchuanshi',
            'Dianchuanshi2',
            'upper',
            'lowwer',
            'action',
            'preside',
            'support',
            'counseling',
            'write',
            'towel',
            'music',
            'service1',
            'traffic',
            'affairs',
            'cooker',
            'uplow',
            'sambo',
            'add',
            'aegis',
            'flower',
            'accounting',
        );

        $tabs = array(array('link'=>'#list', 'val'=>'list', 'word'=>'搜尋', 'sel'=>'active'));

        if(UserService::UserTypeValidator('Agenda_AddTab', Auth::user()->type))
            array_push($tabs, array('link'=>'#registation', 'val'=>'registation', 'word'=>'新增掛號', 'sel'=>''));

        $filter = array();

        $Previous = '';
        $Next = '';
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;

        if(isset($request['type']) && $request['type'] && in_array($request['type'], $type)
            && isset($request['val']) && $request['val']) {
            
            $users = UserService::getUser("concat(b.first_name, b.last_name) like '%".$request['val']."%'", 9999, 1);

            foreach($users as $item) {
                if($request['type'] == 'Dianchuanshi')
                    $filter[] = 'agenda.Dianchuanshi='.$item['Dianchuanshi'];
                else
                    $filter[] = "(agenda.".$request['type']." like '[".$item['id'].",%' or "
                                   ."agenda.".$request['type']." like '%,".$item['id'].",%' or "
                                   ."agenda.".$request['type']." like '%,".$item['id']."]' or "
                                   ."agenda.".$request['type']."=".$item['id'].")";
            }  
        }
        else {
            $request['type'] = '';
            $request['val'] = '';
        }

        if(isset($request['type']) && $request['type'] && $request['type'] == 'course' 
            && isset($request['val']) && $request['val']) {

            $filter[] = "(course_title like '%".$request['val']."%' or song_title like '%".$request['val']."%')";
        }

        if(isset($request['type']) && $request['type'] && $request['type'] == 'lecturer' 
            && isset($request['val']) && $request['val']) {

            $users = UserService::getUsers("concat(first_name, last_name) like '%".$request['val']."%'");
            foreach($users as $item) {
                $filter[] = "(agenda.course_lecturer like '[".$item['id'].",%' or "
                               ."agenda.course_lecturer like '%,".$item['id'].",%' or "
                               ."agenda.course_lecturer like '%,".$item['id']."]' or "

                               ."agenda.song_lecturer like '[".$item['id'].",%' or "
                               ."agenda.song_lecturer like '%,".$item['id'].",%' or "
                               ."agenda.song_lecturer like '%,".$item['id']."]')";
            }
        }

        if(isset($request['start']) && $request['start'] && isset($request['end']) && $request['end']) {

            $request['start'] = str_replace(array('年','月','日'), array('-','-',''), $request['start']);
            $request['end'] = str_replace(array('年','月','日'), array('-','-',''), $request['end']);
            $filter[] = "agenda.add_date between '".$request['start']."' and '".$request['end']."'";
        }
        else {
            $request['start'] = '';
            $request['end'] = '';
        }

        $data = null;
        $getCountType = '';
        if(isset($request['type']) && $request['type'] && $request['type'] == 'member' 
            && isset($request['val']) && $request['val']) {

            $getCountType = 'member';
            $filter = implode(' and ', $filter);

            $data = AgendaService::getDataByMember($filter, $request['val'], $request['page'], 15);
        }
        else {
            $filter = count($filter) > 0 ? implode(' and ', $filter) : '1';
            $data = AgendaService::getAgendaData($filter, $request['page'], 15);
        }

        $pageCount = AgendaService::getPageCount($filter, $getCountType, isset($request['val']) ? $request['val'] : '');

        if($request['page'] == 1)
            $Previous = 'disabled';
        if($request['page'] == $pageCount)
            $Next = 'disabled';

        $linkParam = 'start='.$request['start'].
                        '&end='.$request['end'].
                        '&type='.$request['type'].
                        '&val='.$request['val'];
        $page = PageSupport::getPageArrayStructure('/Agenda', $pageCount, $request['page'], $linkParam);


        $dispatch = CategoryService::get_DDL(isset($request['type']) ? $request['type'] : '','dispatch', '選擇搜尋類別');

        $TempleForArea = TempleService::getTempleForArea();

        return view('BKAgenda')->with('menu', Menu::setMenuList('Agenda'))
                               ->with('userInfo', UserService::getUserBoxInfo())
                               ->with('tabs', $tabs)
                               ->with('areas', $TempleForArea)
                               ->with('users', $data)
                               ->with('page', $page)
                               ->with('pageCount', $pageCount)
                               ->with('Previous', $Previous)
                               ->with('Next', $Next)

                               ->with('dispatch', $dispatch)
                               ->with('lunar_month', LunarDate::getLunarMonth())
                               ->with('operating', TempleService::getAllData() )
                               ->with('lunar_day', LunarDate::getLunarDay())
                               ->with('lunar_hour', LunarDate::getLunarHour())
                               ->with('edus', CategoryService::getDataByType('edu') )
                               ->with('skills', CategoryService::getDataByType('skill') );
    }
}
