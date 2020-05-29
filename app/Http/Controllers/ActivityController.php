<?php

namespace App\Http\Controllers;

use \App\Models\Activity\Service\ActivityService as ActivityService;
use \App\Models\Activity\Service\ActivityTypeService as ActivityTypeService;
use \App\Models\Activity\Service\CenterActivityService as CenterActivityService;
use \App\Models\Activity\Service\CenterActivityTypeService as CenterActivityTypeService;
use \App\Models\Activity\Service\ActivityUserService as ActivityUserService;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Temple\Service\TempleService as TempleService;
use \App\Models\Category\Service\CategoryService as CategoryService;
use \App\Support\PageSupport as PageSupport;
use \App\Support\Comment as Comment;
use \App\Support\Menu as Menu;
use Request;
use Auth;
use DB;

class ActivityController extends Controller
{
    public function doAddActivity(Request $request)
    {
        $request = $request::all();

        $TypeName = ActivityTypeService::getData('id='.$request['type'], 1, 9999)[0]['title'];
        $request['add_date'] = str_replace(array('年','月','日'), array('-','-',''), $request['add_date']);

        try {

            DB::beginTransaction();

            $activity = new \App\Models\Activity\Entity\Activity;
            $activity->type = $TypeName;
            $activity->preside = json_encode($request['preside']);
            $activity->course_title = json_encode($request['course_title']);
            $activity->course_lecturer = json_encode($request['course']);
            if(isset($request['song_title']) && isset($request['song_title'])) {
                $activity->song_title = json_encode($request['song_title']);
                $activity->song_lecturer = json_encode($request['song']);
            }            
            $activity->add_date = $request['add_date'];
            $activity->last_edit = Auth::id();
            $activity->save();
            
            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function ActivityView(Request $request)
    {
        $request = $request::all();

        $id=null;
        if(isset($request['upid']) && $request['upid']) $id =  $request['upid'];

        $Previous = array();
        $Next = array();
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;

        $tabs = ActivityTypeService::getActivityType($request);

        $data = null;
        $pageCount = null;
        $page = array();
        if($id==null) {
            //對課程分類，後進行資料注入
            $clsType = ActivityTypeService::getAll();
            $Types = array();
            foreach($clsType as $item) {
                $Types[$item['title']] = array();
            }
            

            foreach($Types as $key => $val) {
                $res = ActivityUserService::getActivityUser("activity.type='".$key."'", $request['page'], 15);
                $Types[$key] = $res;
            }

            $data = $Types;

            $pageCount = ActivityService::getGroupCount();
            //無條件進位
            foreach($pageCount as &$item) {
                $item['count'] = $item['count']/15;
                $item['count'] = ceil($item['count']);

                if($request['page'] == 1)
                    $Previous[$item['type']] = 'disabled';
                else
                    $Previous[$item['type']] = '';
                if($request['page'] == $item['count'])
                    $Next[$item['type']] = 'disabled';
                else
                    $Next[$item['type']] = '';
            }
            unset($item);
            
            foreach($pageCount as &$item) {
                $linkParam = 'tab='.$item['type'];
                $page[$item['type']] = PageSupport::getPageArrayStructure('/Activity', $item['count'], $request['page'], $linkParam);
            }
        }
        else {
            $cls = ActivityUserService::getActivityUserByaid("upid=".$id, $request['page'], 15);

            $aids = array();
            foreach($cls as $item) {
                $aids[] = $item['aid'];
            }
            $aids = array_unique($aids);

            $data = ActivityService::getDataByWhereIn('id', $aids);

            $users = ActivityController::getUsersIdFromJson($data);
            $data = ActivityController::UserinfoInData($data, 'preside', $users);
            $data = ActivityController::UserinfoInData($data, 'course_lecturer', $users);
            $data = ActivityController::UserinfoInData($data, 'song_lecturer', $users);
            $data = Comment::JsonToArray($data, array('course_title', 'song_title'));
        }

        $MonthOfModal = array(
            array('word'=>date('m').'月', 'val'=>date('m'), 'offset'=>0), 
            array('word'=>(date('m')-1).'月', 'val'=>date('m'), 'offset'=>1));

        $lastMonth = date('Y-m', strtotime("last month")).'-1';

        return view('BKActivity')->with('menu', Menu::setMenuList('Activity'))
                                 ->with('userInfo', UserService::getUserBoxInfo())
                                 ->with('btnShow', UserService::UserTypeValidator('AddActivity_Record', Auth::user()->type))
                                 
                                 ->with('id', $id)
                                 ->with('tab', $tabs)
                                 ->with('data', $data)
                                 ->with('page', $page)
                                 ->with('pageCount', $pageCount)
                                 ->with('Previous', $Previous)
                                 ->with('Next', $Next)
                                 ->with('MonthOfModal', $MonthOfModal)
                                 ->with('edus', CategoryService::getDataByType('edu') )
                                 ->with('skills', CategoryService::getDataByType('skill') );
    }

    public function ActivityManageView(Request $request)
    {
        $request = $request::all();

        if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

        if(isset($request['tab']) && $request['tab'])
            $tab = $request['tab'];
        else
            $tab = 'cls';

        $tabs = array(
            array('link'=>'#cls', 'val'=>'cls', 'word'=>'地方班程', 'sel'=>'active'),
            array('link'=>'#center', 'val'=>'center', 'word'=>'中心班程', 'sel'=>''));

        //process tab active
        foreach($tabs as &$t) {
            $t['sel'] = '';
            if($t['val'] == $tab) $t['sel'] = 'active';
        }
        unset($t);

        $filter = array(
            "add_date >= '".$y."-01-01'",
            "add_date < '".($y+1)."-01-01'",);
        $data = ActivityService::getDataByGroupBy(implode(' and ', $filter), 'type');
        
        $ddlActivity = ActivityTypeService::getAll();

        //get distinct year
        $AcDate = ActivityService::getActivityYears();
        $years = Comment::getYear_DDL($AcDate, isset($request['year']) ? $request['year'] : '');


        //center
        $c_data = CenterActivityService::getDataByGroupBy(implode(' and ', $filter), 'type');

        $c_ddlActivity = CenterActivityTypeService::getAll();


        //get distinct year
        $AcDate = CenterActivityService::getActivityYears();
        $c_years = Comment::getYear_DDL($AcDate, isset($request['year']) ? $request['year'] : '');

        return view('BKClsmanag')->with('menu', Menu::setMenuList('Clsmanag'))
                                 ->with('userInfo', UserService::getUserBoxInfo())
                                 ->with('tabs', $tabs)
                                 ->with('data', $data)
                                 ->with('c_data', $c_data)
                                 ->with('ddlActivity', $ddlActivity)
                                 ->with('c_ddlActivity', $c_ddlActivity)
                                 ->with('year', $years)
                                 ->with('c_year', $c_years)
                                 ->with('y', $y)
                                 ->with('tab', $tab)
                                 ->with('operating', TempleService::getAllData() );
    }

    public function ActivityDetailView(Request $request)
    {
        $request = $request::all();
        $tabTitle = '';
        if(isset($request['data']) && $request['data']) {
            $year = substr($request['data'], strlen($request['data'])-4);
            $title = substr($request['data'], 0, strlen($request['data'])-4);
            $tabTitle = $year.''.$title;

            $filter = array(
                "add_date >= '".$year."-01-01'",
                "add_date < '".($year+1)."-01-01'",
                "type = '".$title."'"
                );
            $data = ActivityService::getData(implode(' and ', $filter), '*', 1, 9999);

            $users = ActivityController::getUsersIdFromJson($data);
            $data = ActivityController::UserinfoInData($data, 'preside', $users);
            $data = ActivityController::UserinfoInData($data, 'course_lecturer', $users);
            $data = ActivityController::UserinfoInData($data, 'song_lecturer', $users);
            $data = Comment::JsonToArray($data, array('course_title', 'song_title'));

            $ddlActivity = ActivityTypeService::getAll();

            return view('BKClsDetail')->with('menu', Menu::setMenuList('Clsmanag'))
                                 ->with('userInfo', UserService::getUserBoxInfo())
                                 ->with('tabTitle', $tabTitle)
                                 ->with('ddlActivity', $ddlActivity)
                                 ->with('data', $data);
        }
    }

    public function doGetActivityData(Request $request)
    {
        $request = $request::all();

        $data = ActivityService::getData('id='.$request['id'], '*', 1, 9999);

        $typeID = ActivityTypeService::getData("title='".$data[0]['type']."'", 1, 9999)[0]['id'];
        $data[0]['typeID'] = $typeID;

        $users = ActivityController::getUsersIdFromJson($data);
        $data = ActivityController::UserinfoInData($data, 'preside', $users);
        $data = ActivityController::UserinfoInData($data, 'course_lecturer', $users);
        $data = ActivityController::UserinfoInData($data, 'song_lecturer', $users);
        $data = Comment::JsonToArray($data, array('course_title', 'song_title'));

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doUpdateActivityData(Request $request)
    {
        $request = $request::all();

        $TypeName = ActivityTypeService::getData('id='.$request['type'], 1, 9999)[0]['title'];
        $request['add_date'] = str_replace(array('年','月','日'), array('-','-',''), $request['add_date']);

        $updateData = array();
        $updateData['type'] = $TypeName;
        $updateData['preside'] = json_encode($request['preside']);
        $updateData['course_title'] = json_encode($request['course_title']);
        $updateData['course_lecturer'] = json_encode($request['course']);
        $updateData['song_title'] = json_encode($request['song_title']);
        $updateData['song_lecturer'] = json_encode($request['song']);
        $updateData['add_date'] = $request['add_date'];
        $updateData['last_edit'] = 1;

        try {
            DB::beginTransaction();

            ActivityService::update('id='.$request['id'], $updateData);

            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doDelActivity(Request $request)
    {
        $request = $request::all();

        try {
            DB::beginTransaction();

            ActivityService::delete('id='.$request['id']);

            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doGetLastActivityData(Request $request)
    {
        $request = $request::all();

        $data = array();
        if(isset($request['id']) && $request['id']) {
            $data = ActivityService::getData('id='.$request['id'], '*', 1, 9999);

            $users = ActivityController::getUsersIdFromJson($data);
            $data = ActivityController::UserinfoInData($data, 'preside', $users);
            $data = ActivityController::UserinfoInData($data, 'course_lecturer', $users);
            $data = ActivityController::UserinfoInData($data, 'song_lecturer', $users);
            $data = Comment::JsonToArray($data, array('course_title', 'song_title'));
        }

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doGetActivityUser(Request $request)
    {
        $request = $request::all();

        $filter = array("activity.type='".$request['type']."'");
        $data = ActivityUserService::getActivityUser(implode(' and ', $filter), 1, 9999);

        $total = ActivityService::getData("type='".$request['type']."'" ,'count(*) as total', 1, 9999)[0]['total'];

        foreach($data as &$item) {
            $item['total'] = $total;
        }
        unset($item);

        echo json_encode(array('data'=>$data));
        exit();
    }

    public function doDeleteActivityUser(Request $request)
    {
        $request = $request::all();

        try {
            DB::beginTransaction();

            $res = ActivityUserService::getData('id='.$request['id'], 1, 9999)[0];
            $name = $res['name'];
            $inDB = $res['inDB'];

            $filter = array(
                "activity_user.name='".$name."'",
                "inDB='".$inDB."'",
                "aid=".$request['aid']
                );
            ActivityUserService::delete(implode(' and ', $filter));

            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doAddActivityUser(Request $request)
    {
        $request = $request::all();

        $filter = array(
            'aid='.$request['aid'],
            "upid='".$request['upid']."'",
            "name='".$request['name']."'",
            "inDB='".$request['inDB']."'"
            );
        $count = ActivityUserService::getCount(implode(' and ', $filter), 1, 9999);

        if($count > 0) {
            echo json_encode('already exists');
            exit();
        }

        if($request['upid'] != 0) {
            $templeID = UserService::getUser('a.id='.$request['upid'], 9999, 1)[0]['tid'];
        }

        $a_user = new \App\Models\Activity\Entity\ActivityUser;
        $a_user->aid = $request['aid'];
        $a_user->upid = $request['upid'];
        $a_user->name = $request['name'];
        $a_user->inDB = $request['inDB'];
        $a_user->gender = $request['gender'];
        $a_user->year = $request['year'];
        $a_user->temple = $request['upid']!=0 ? $templeID : 0;
        $a_user->mobile = $request['mobile'];
        $a_user->phone = $request['phone'];
        $a_user->edu = $request['edu'];
        $a_user->skill = $request['skill']; 
        $a_user->addr = $request['addr'];
        $a_user->save();

        DB::commit();

        $data = ActivityUserService::getData(implode(' and ', $filter), 1, 9999)[0];

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function dogetActivityLastTwoMonthData(Request $request)
    {
        $request = $request::all();

        $lastMonth = date('Y-m', strtotime("last month")).'-1';
        $filter = array(
            "add_date < '".date('Y-m', strtotime("next month"))."-1'",
            "add_date >= '".date('Y-m', strtotime($lastMonth.' -1 day'))."'",
            "type='".$request['type']."'"
            );
        $data = ActivityService::getData(implode(' and ', $filter), '*', 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));
        exit();
    }

    public function doAddActivityAttend(Request $request)
    {
        $request = $request::all();

        if(!isset($request['attendID']) || !$request['attendID']) {
            echo json_encode('success');
            exit();
        }

        try {

            DB::beginTransaction();

            foreach($request['attendID'] as $auid) {
                $aa = new \App\Models\Activity\Entity\ActivityAttend;
                $aa->aid = $request['aid'];
                $aa->auid = $auid;
                $aa->save();
            }

            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }

        echo json_encode($request);
        exit();
    }

    //抓所有相關人員ID並排序
    private static function getUsersIdFromJson($data)
    {
        $ids = array();
        foreach($data as $d) {
            
            $ary = json_decode($d['preside']);
            foreach($ary as $item)
                $ids[] = $item;

            $ary = json_decode($d['course_lecturer']);
            foreach($ary as $item)
                $ids[] = $item;

            $ary = json_decode($d['song_lecturer']);
            foreach($ary as $item)
                $ids[] = $item;
        }
        $ids = array_unique($ids);

        $users = UserService::getUsersByWhereIn('id', $ids);

        return $users;
    }

    //相關人員Json become Array
    private static function UserinfoInData($data, $field, $users)
    {
        foreach($data as &$d) {

            if(Comment::is_json($d[$field]))
                $js = json_decode($d[$field],true);
            else 
                $js[] = $d[$field];
            
            $d[$field] = array();

            $tmp = array();
            foreach($users as $u) {
                foreach($js as $item) {
                    if($item == $u['id']) {                
                        array_push($tmp, $u);
                    }
                    $d[$field] = $tmp;
                }
            }
        }
        unset($d);

        return $data;
    }
}
