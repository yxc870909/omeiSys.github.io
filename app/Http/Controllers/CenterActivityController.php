<?php

namespace App\Http\Controllers;

use \App\Models\Activity\Service\CenterActivityService as CenterActivityService;
use \App\Models\Activity\Service\CenterActivityTypeService as CenterActivityTypeService;
use \App\Models\Activity\Service\CenterActivityUserService as CenterActivityUserService;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Category\Service\CategoryService as CategoryService;
use \App\Support\PageSupport as PageSupport;
use \App\Support\Comment as Comment;
use \App\Support\Menu as Menu;
use Request;
use Auth;
use DB;

class CenterActivityController extends Controller
{
    public function CenterActivityView(Request $request)
    {
        $request = $request::all();

        if(isset($request['year']) && $request['year']) 
            $y = $request['year'];
        else
            $y = date('Y');

        $tab = CenterActivityTypeService::getAll();
        $tmp = array();
        $i=0;
        foreach($tab as $item) {
            array_push($tmp, array(
                'id'=>$item['id'],
                'title'=>$item['title'],
                'active'=>$i==0 ? 'active' : ''
                ));
            $i++;
        }
        $tab = $tmp;

        $filter = array(
            "add_date >= '".$y."-01-01'",
            "add_date < '".($y+1)."-01-01'"
         );
        $data = CenterActivityService::getDataByGroupByWithUser(implode(' and ', $filter), 'center_activity.id');

        //get distinct year
        $AcDate = CenterActivityService::getActivityYears();
        $years = Comment::getYear_DDL($AcDate, isset($request['year']) ? $request['year'] : '');

        return view('BKCenterActivity')->with('menu', Menu::setMenuList('CenterActivity'))
                                        ->with('userInfo', UserService::getUserBoxInfo())
                                        ->with('btnShow', UserService::UserTypeValidator('AddCenter_Record', Auth::user()->type))

                                        ->with('tabs', $tab)
                                        ->with('data', $data)
                                        ->with('year', $years)
                                        ->with('edus', CategoryService::getDataByType('edu') )
                                        ->with('skills', CategoryService::getDataByType('skill') );
    }

    public function CenterDetailView(Request $request)
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
                "type='".$title."'"
            );
            $data = CenterActivityService::getDataByGroupByWithUser(implode(' and ', $filter), 'center_activity.id');

            return view('BKCenterDetail')->with('menu', Menu::setMenuList('CenterActivity'))
                                        ->with('userInfo', UserService::getUserBoxInfo())
                                        ->with('tabTitle', $tabTitle)
                                        ->with('data', $data);
        }


    	return \App\Models\Entity\CenterActivity::CenterDetailView($request::all());
    }
    
    public function doAddCenterActivity(Request $request)
    {
        $request = $request::all();

        $TypeName = CenterActivityTypeService::getData('id='.$request['type'], 1, 9999)[0]['title'];
        $request['add_date'] = str_replace(array('年','月','日'), array('-','-',''), $request['add_date']);

        try {

            DB::beginTransaction();

            $centeractivity = new \App\Models\Activity\Entity\CenterActivity;
            $centeractivity->type = $TypeName;
            $centeractivity->add_date = $request['add_date'];
            $centeractivity->last_edit = Auth::id();
            $centeractivity->save();

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

    public function doGetCenterActivityLastTwoMonthData(Request $request)
    {
        $request = $request::all();

        $lastMonth = date('Y-m', strtotime("last month")).'-1';
        $filter = array(
            "add_date < '".date('Y-m', strtotime("next month"))."-1'",
            "add_date >= '".date('Y-m', strtotime($lastMonth.' -1 day'))."'",
            "type='".$request['type']."'"
        );

        $data = CenterActivityService::getData(implode(' and ', $filter), '*', 1, 9999);

        echo json_encode(array('status'=>'success', 'data'=>$data));        
        exit();
    }

    public function doGetCenterActivityUser(Request $request)
    {
        $request = $request::all();

        $filter = array("center_activity.id='".$request['id']."'");
        $data = CenterActivityUserService::getActivityUser(implode(' and ', $filter), 1, 9999);

        echo json_encode(array('data'=>$data));
        exit();
    }

    public function doDeleteCenterActivityUser(Request $request)
    {
        $request = $request::all();

        try {
            DB::beginTransaction();

            $res = CenterActivityUserService::getData('id='.$request['id'], 1, 9999)[0];
            $name = $res['name'];
            $inDB = $res['inDB'];

            $filter = array(
                "center_activity_user.name='".$name."'",
                "inDB='".$inDB."'",
                "caid=".$request['caid']
            );
            CenterActivityUserService::delete(implode(' and ', $filter));

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

    public function doAddCenterActivityUser(Request $request)
    {
        $request = $request::all();

        try {
            DB::beginTransaction();

            $filter = array(
                "upid=".$request['upid'],
                "caid=".$request['caid'],
                "name='".$request['name']."'",
                "inDB='".$request['inDB']."'",
            );
            $count = CenterActivityUserService::getCount(implode(' and ', $filter), 1, 9999);

            if($count > 0) {
                echo json_encode('already exists');
                exit();
            }

            if($request['upid'] != 0) {
                $templeID = UserService::getUser('a.id='.$request['upid'], 9999, 1)[0]['tid'];
            }

            $a_user = new \App\Models\Activity\Entity\CenterActivityUser;
            $a_user->caid = $request['caid'];
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

            // $DataCount = CenterActivityUserService::getCount('1', 1, 9999);
            $data = CenterActivityUserService::getData(implode(' and ', $filter), 1, 9999)[0];

            echo json_encode(array('status'=>'success', 'data'=>$data));
            exit();
        }
        catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doUpdateUserCenterStatus(Request $request)
    {
        $request = $request::all();

        if($request['status'] == 'finish') {
            $record = new \App\Models\Activity\Entity\CenterRecord;
            $record->caid = $request['id'];
            $record->upid = $request['upid'];
            $record->save();
            echo json_encode('success');
            exit();
        }
        echo json_encode('');
        exit();
    }
}
