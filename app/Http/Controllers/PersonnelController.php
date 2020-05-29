<?php

namespace App\Http\Controllers;

use Request;
use \App\Checker\PersonnelValidator as PersonnelValidator;
use \App\Checker\AccountValidator as AccountValidator;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Temple\Service\TempleService as TempleService;
use \App\Models\Category\Service\CategoryService as CategoryService;
use \App\Support\PageSupport as PageSupport;
use \App\Support\LunarDate as LunarDate;
use \App\Support\Comment as Comment;
use \App\Support\Menu as Menu;

use DB;
use Auth;

class PersonnelController extends Controller
{
    public function doRegisterUser(Request $request)
    {
        $request = $request::all();

        $validator = AccountValidator::RegisterValidator($request);

        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }
        else if($request['password'] != $request['confirm']) {
            echo json_encode(array('confirm'=>'* 輸入資料與密碼不符'));
            exit();
        }
        else if($request['upid'] == '') {
            echo json_encode(array('upid'=>'* 尚未選取道親資料'));
            exit();
        }
        else {

            $data = UserService::find($request['upid'])[0];
            // $data = User::where('id', '=', $request['upid'])->get()[0];
            if($data['email'] != '') {
                echo json_encode(array('status' => 'used'));
                exit;
            }

            $data = UserService::getUser("uid='".$request['account']."'", 9999, 1);
            // $data = User::where('uid', '=', $request['account'])->get();

            if(count($data) > 0) {
                echo json_encode(array('status' => 'regitsted'));
                exit;
            }
            
            try {
                DB::beginTransaction();

                $activation_code = Comment::getrank(60);
                $user = \App\Models\User\Entity\User::find($request['upid']);
                $user['uid'] = $request['account'];
                $user['email'] = $request['account'];
                $user['password'] = bcrypt($request['password']);
                $user['activation_code'] = $activation_code;
                $user['register_date'] = date('Y-m-d');
                $user->save();

                DB::commit();
                
                $activation_link='http://'.$_SERVER["SERVER_NAME"].'/AuthCode?upid='.$request['upid'].'&activation_code=' . $activation_code;
                $msg = '歡迎使用『峨眉書院道務資訊系統』,請點擊下方網址做開通動作<br>'.$activation_link;

                $user = User::find($request['upid']);
                Mail::send(['html'=>'layouts.authcode'], ['text'=>$msg], function ($m) use ($user) {
                    $m->sender('yxc87090909@gmail.com');
                    $m->to($user['email'])->subject('峨嵋道務系統認證信');
                });

                echo json_encode(array('status'=>'success'));
                exit();

            }catch(Exception $e) {
                DB::rollback();
                echo json_encode($e);
                exit();
            }
        }
    }

    public function doGetUserData(Request $request)
    {
        $request = $request::all();

        $user = UserService::find($request['upid']);

        if(count($user) == 0) {
            echo json_encode('unfind');
            exit();
        }

        $user = $user[0];
        $hash = CategoryService::getHashTable(array('edu', 'skill'));
        $user['edu_word'] = $user['edu'] != '' ? $hash['edu'][$user['edu']]['word'] : '';
        $user['skill_word'] = $user['skill'] != '' ? $hash['skill'][$user['skill']]['word'] : '';


        echo json_encode(array('status'=>'success', 'data'=>$user));
        exit();
    }

	public function doGetUserData2(Request $request)
	{
		$request = $request::all();
		$data = UserService::getPersonnelViewInfo($request['upid']);

		foreach($data as $k=>&$v) {
            if($v == null) $v = '';
        }
        unset($v);

		echo json_encode($data);
        exit();
	}

	public function doGetPersonnel_edit(Request $request)
	{
		$request = $request::all();
		$data = UserService::getPersonnelViewInfo($request['upid']);

		$user_type = CategoryService::getDataByType('user_type');
        foreach($user_type as &$uy) {
            if($uy['value'] == $data['type'])
                $uy['checked'] = 'checked';
        }
        unset($uy);
        $data['type'] = $user_type;

        $edus = CategoryService::getDataByType('edu');
        foreach($edus as &$edu) {
            if($edu['value'] == $data['edu'])
                $edu['checked'] = 'checked';
        }
        unset($edu);
        $data['edu'] = $edus;

        $skills = CategoryService::getDataByType('skill');
        foreach($skills as &$skill) {
            if($skill['value'] == $data['skill'])
                $skill['checked'] = 'checked';
        }
        unset($skill);
        $data['skill'] = $skills;

        $positions = CategoryService::getDataByType('position');
        if($data['position'] != '') {

            $post_list = $data['position'];
            foreach($positions as &$position) {
                foreach($post_list as $list) {
                    if($position['value'] == $list)
                        $position['checked'] = 'checked'; 
                }
            }
            unset($position);   
        }
        $data['position'] = $positions;

        echo json_encode($data);
        exit();
	}

    public function doUpdateFaimly(Request $request)
    {
        $request = $request::all();

        if($request['father'] == '') $father = 0;
        else $father = $request['father'];

        if($request['mother'] == '') $mother = 0;
        else $mother = $request['mother'];

        if($request['spouse'] == '') $spouse = 0;
        else $spouse = $request['spouse'];

        if(!isset($request['brosis'])) $brosis = '[]';
        else $brosis = json_encode($request['brosis']);

        if(!isset($request['child'])) $child = '[]';
        else $child = json_encode($request['child']);

        if(!isset($request['relative'])) $relative = '[]';
        else $relative = json_encode($request['relative']);


        try {
            DB::beginTransaction();

            $user = \App\Models\User\Entity\User::find($request['upid']);
            $user->father = $father;
            $user->mother = $mother;
            $user->spouse = $spouse;
            $user->brosis = $brosis;
            $user->child = $child;
            $user->relative = $relative;
            $user->save();

            DB::commit();

            echo json_encode('success');
            exit();

        }catch(Exception $e) {
            DB::rollback();
            echo json_encode($e);
            exit();
        }


        echo json_encode($request);
        exit();
    }

	public function doSearchUser( Request$request)
	{
		$request = $request::all();
		$user = UserService::SearchUser($request['search']);

		if(count($user) == 0) {
    		echo json_encode('unfind');
    		exit();
    	}

    	if(count($user) > 1) {
    		echo json_encode('more-fail');
    		exit();
    	}

    	echo json_encode(array('status'=>'success', 'data'=>$user[0]));
    	exit();
	}

    public function doSavePersonnel_edit(Request $request)
    {
        $request = $request::all();

        if($request['father'] == '') $father = 0;
        else $father = $request['father'];

        if($request['mother'] == '') $mother = 0;
        else $mother = $request['mother'];

        if($request['spouse'] == '') $spouse = 0;
        else $spouse = $request['spouse'];

        if(!isset($request['brosis'])) $brosis = '[]';
        else $brosis = json_encode($request['brosis']);

        if(!isset($request['child'])) $child = '[]';
        else $child = json_encode($request['child']);

        if(!isset($request['relative'])) $relative = '[]';
        else $relative = json_encode($request['relative']);

        $updteData = array();
        if(isset($request['type']))
            $updteData['type'] = $request['type'];
        $updteData['last_name'] = $request['last_name'];
        $updteData['first_name'] = $request['first_name'];
        $updteData['phone'] = $request['phone'];
        $updteData['mobile'] = $request['mobile'];
        $updteData['year'] = $request['year'];
        if(isset($request['edu']))
        $updteData['edu'] = $request['edu'];
        if(isset($request['skill']))
            $updteData['skill'] = $request['skill'];
        if(isset($request['position']))
            $updteData['position'] = json_encode($request['position']);
        $updteData['father'] = $father;
        $updteData['mother'] = $mother;
        $updteData['spouse'] = $spouse;
        $updteData['brosis'] = $brosis;
        $updteData['child'] = $child;
        $updteData['relative'] = $relative;
        
        try {
            DB::beginTransaction();

            UserService::update($request['upid'], $updteData);

            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e) {
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doAddUser_worker(Request $request)
    {
        $request = $request::all();
        $user = UserService::SearchUser($request['search']);

        if(count($user) == 1) {
            echo json_encode(array('status'=>'success', 'data'=>$user[0]));
            exit();
        }

        if(count($user) > 1) {
            echo json_encode(array('status'=>'more-fail'));
            exit();
        }

        if(count($user) == 0) {
            echo json_encode(array('status'=>'unfind'));
            exit();
        }
    }

    public function doAddUser(Request $request)
    {
        $request = $request::all();
        if($request['type'] == 'single')
            $validator = PersonnelValidator::AddSinglePersonnelValidator($request);
        else if($request['type'] == 'multi')
            $validator = PersonnelValidator::AddMultiPersonnelValidator($request);

        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        $first_name = array();
        $last_name = array();
        foreach($request['name'] as $item) {
            $first_name[] = substr($item, 0,3);
            $last_name[] = substr($item, 3);
        }

        try {
            DB::beginTransaction();
            $request['add_date'] = str_replace(array('年','月','日'), array('-','-',''), $request['add_date']);
            $request['add_date2'] = $request['yyy'].'年-'.$request['yy'].'-'.$request['mm'].'-'.$request['dd'].'-'.$request['hh'].'時';
            $action = isset($request['action']) ? json_encode($request['action']) : '';
            $support = isset($request['support']) ? json_encode($request['support']) : '';
            $service1= isset($request['service1']) ? json_encode($request['service1']) : '';
            $service2 = isset($request['service2']) ? json_encode($request['service2']) : '';
            $towel = isset($request['towel']) ? json_encode($request['towel']) : '';
            $traffic= isset($request['traffic']) ? json_encode($request['traffic']) : '';
            $cooker= isset($request['cooker']) ? json_encode($request['cooker']) : '';
            $sambo= isset($request['sambo']) ? json_encode($request['sambo']) : '';
            $Introduction= isset($request['Introduction']) ? json_encode($request['Introduction']) : '';
            $preside= isset($request['preside']) ? json_encode($request['preside']) : '';

            $regist = new \App\Models\Regist\Entity\Regist;
            $regist->tid = $request['tid'];
            $regist->upper = isset($request['upper']) ? $request['upper'] : '';
            $regist->lowwer = isset($request['uplow']) ? $request['lowwer'] : '';
            $regist->action = $action;
            $regist->support = $support;
            $regist->service1 = $service1;
            $regist->service2 = $service2;
            $regist->towel = $towel;
            $regist->traffic = $traffic;
            $regist->cooker = $cooker;
            $regist->sambo = $sambo;
            $regist->Introduction = $Introduction;
            $regist->preside = $preside;
            $regist->uplow = isset($request['uplow']) ? $request['uplow'] : '';
            $regist->add = isset($request['add']) ? $request['add'] : '';
            $regist->translation = isset($request['translation']) ? $request['translation'] : '';
            $regist->peper = isset($request['peper']) ? $request['peper'] : '';
            $regist->aegis = isset($request['aegis']) ? $request['aegis'] : '';
            $regist->add_date = $request['add_date'];
            $regist->add_date2 = $request['add_date2'];
            $regist->save();

            DB::commit();

            $last_id = \App\Models\Regist\Entity\Regist::orderBy('id','desc')->take(1)->first()->id;

            DB::beginTransaction();
            for($i=0; $i<count($request['name']); $i++) {
                $user = new \App\Models\User\Entity\User;
                $user->first_name = $first_name[$i];
                $user->last_name = $last_name[$i];
                $user->gender = $request['gender'][$i];
                if(isset($request['Dianchuanshi'])) {
                    if(is_numeric($request['Dianchuanshi'][$i]))
                        $user->Dianchuanshi = $request['Dianchuanshi'][$i];
                    else 
                        $user->Dianchuanshi_out = $request['Dianchuanshi'][$i];
                }
                
                $user->Introducer = $request['Introducer'][$i];
                $user->Guarantor = $request['Guarantor'][$i];
                $user->year = $request['year'][$i];
                $user->mobile = $request['mobile'][$i];
                $user->phone = $request['phone'][$i];
                $user->edu = $request['edu'][$i];
                $user->skill = $request['skill'][$i];
                $user->addr = $request['addr'][$i];
                $user->area = $request['area'];
                $user->regist_id = $last_id;
                $user->save();
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
    }

    public function doShowUsers(Request $request)
    {
        $request = $request::all();

        $user = UserService::getUser("concat(a.first_name,a.last_name) like '%".$request['search']."%'", 1, 0);
        
        $hash = CategoryService::getHashTable(array('area'));
        if($user!='') {
            $user[0]['area_word'] = $hash['area'][$user[0]['area']]['word'];
        }
        else {
            $user[0]['area_word'] = $user[0]['area'];
        }
        
        if(count($user) == 0) {
            echo json_encode('unfind');
            exit();
        }

        echo json_encode(array('status'=>'success', 'data'=>$user));
        exit();
    }

    public function PersonnelView(Request $request)
    {
    	$request = $request::all();
    	

    	//tabs
        $tabs = array(array('link'=>'#list', 'val'=>'list', 'word'=>'搜尋', 'sel'=>'active'));

        if(UserService::UserTypeValidator('AddUser_AddTab', Auth::user()->type))
            array_push($tabs, array('link'=>'#registation', 'val'=>'registation', 'word'=>'新增掛號', 'sel'=>''));
            // array_push($tabs, array('link'=>'#', 'val'=>'', 'word'=>'新增掛號', 'sel'=>'disabled'));
        if(UserService::UserTypeValidator('GroupTab', Auth::user()->type))
            array_push($tabs, array('link'=>'#work', 'val'=>'work', 'word'=>'團隊人事', 'sel'=>''));


        //filter
        $filter = array();

        $Previous = '';
        $Next = '';
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;

        if(isset($request['area']) && $request['area']) {
            $filter[] = "a.area = '".$request['area']."'";
            $a = $request['area']; 
        }
        else
            $request['area'] = '';

    	if(isset($request['group']) && $request['group']) {
            $filter[] = "g.group = '".$request['group']."'";
            $filter[] = "g.year = ".date('Y');
            $g = $request['group'];     
        }
        else
            $request['group'] = '';

        $p = array();
        $posi_get = array();
        if(isset($request['position']) && count($request['position']) > 0) {        	
        	foreach($request['position'] as $item) {
        		$p[] = "a.position like '%".$item."%'";
                $posi_get[] = 'position%5B%5D='.$item;
        	}
            $filter[] = '('.implode(' or ', $p).')';
            $p = $request['position'];
        }
        else
            $request['position'] = '';

        $work_get = array();
        if(isset($request['work']) && count($request['work']) > 0) {
            $w = array();
        	foreach($request['work'] as $item) {
        		$w[] = "a.work like '".$item."'";
                $work_get[] = 'work%5B%5D='.$item;
        	}
            $filter[] = '('.implode(' or ', $w).')';
            $w = $request['work'];
        }
        else
            $request['work'] = '';

        if(isset($request['name']) && $request['name']) {
            $filter[] = DB::raw("concat(a.first_name, a.last_name) like '%".$request['name']."%'");
        }
        else
            $request['name'] = '';

        $tpler = '';
        if(isset($request['templer']) && $request['templer']) {
            $filter[] = "1";
            $tpler = 'checked';
        }
        else 
            $request['templer'] = '';
        
        $filter = count($filter) > 0 ? implode(' and ', $filter) : "1";

        //get data
        $users = null;
        if($filter) {
        	if(isset($request['templer']) && $request['templer'])
        		$users = UserService::getUsersOfTempler(Auth::id(), $filter, $request['page']);
        	else
        		$users = UserService::getUsersOfTemple(Auth::id(), $filter, $request['page']);
        }
        else
        	$users = UserService::getUsersOfTemple(Auth::id(), $filter, $request['page']);


        //page
        $upids = array();
        if(isset($request['templer']) && $request['templer'])
        	$upids = UserService::getAllHostOfTemple();
        
        $pageCount = UserService::getPageCount($filter, $upids);

        if($request['page'] == 1)
            $Previous = 'disabled';
        if($request['page'] == $pageCount)
            $Next = 'disabled';

        $linkParam = 'area='.$request['area'].
                    '&group='.$request['group'].
                    '&name='.$request['name'].
                    '&'.implode('&', $posi_get).
                    '&'.implode('&', $work_get).
                    '&templer='.$request['templer'];

        $page = PageSupport::getPageArrayStructure('/Personnel', $pageCount, $request['page'], $linkParam);


        //get option
        $area = CategoryService::get_DDL(isset($a) ? $a : '', 'area', '選擇佛堂區域');
        $group = CategoryService::get_DDL(isset($g) ? $g : '', 'group', '選擇搜尋類別');
        $position = CategoryService::get_CheckBoxList(isset($p) ? $p : array(), 'position');
	    $work = CategoryService::get_CheckBoxList(isset($w) ? $w : array(), 'work');
        $templer = array(array('value'=>'templer', 'word'=>'壇主', 'checked'=>$tpler));

        if(count($users) > 0) {
        	$hash = CategoryService::getHashTable(array('gender', 'position', 'work', 'group', 'group_type'));
        	$users = CategoryService::getValueToWord($hash, 'gender', $users);
        	$users = CategoryService::getValueToWord($hash, 'work', $users);
        	$users = CategoryService::getValueToWord($hash, 'group', $users);
        	$users = CategoryService::getValueToWord($hash, 'group_type', $users);

        	foreach($users as &$item) {
        		if($item['position']!='' && $item['position']!='[]') {     			
	     			$positions = json_decode($item['position'], true);
	     			$item['position'] = '';
	     			
	     			foreach($positions as &$p) {
	     				$p = $hash['position'][$p]['word'];
	     			}
	     			unset($p);
	     			$item['position'] = implode(', ', $positions);

                    
	     		}
                else if($item['position']=='[]')
                    $item['position'] = '';
        	}
        	unset($item);
        }

        //今年與後兩年年度(民國)
	     $yearly = array(
	     	date('Y'),
	     	date('Y')-1,
	     	date('Y')-2
	     	);	 
        

        return view('BKPersonnel')->with('menu', Menu::setMenuList('Personnel'))
    						 ->with('userInfo', UserService::getUserBoxInfo())
                             ->with('editShow', UserService::UserTypeValidator('EditPersonnel', Auth::user()->type))
                             ->with('EditAuth', UserService::UserTypeValidator('EditPersonnel_Auth', Auth::user()->type))

							->with('tabs', $tabs)
							->with('users', $users)
                            ->with('page', $page)
                            ->with('pageCount', $pageCount)
                            ->with('Previous', $Previous)
                            ->with('Next', $Next)
                            ->with('linkParam', $linkParam)

							->with('areas', CategoryService::getDataByType('area') )
							->with('positions', $position )
                            ->with('ddl_areas', $area)
							->with('works', $work )
                            ->with('templer', $templer )
							->with('groups', $group )
							->with('edus', CategoryService::getDataByType('edu') )
							->with('operating', TempleService::getAllData() )
							->with('skills', CategoryService::getDataByType('skill') )
							->with('lunar_month', LunarDate::getLunarMonth())
							->with('lunar_day', LunarDate::getLunarDay())
							->with('lunar_hour', LunarDate::getLunarHour())
							->with('yearly', $yearly);
    }
}
