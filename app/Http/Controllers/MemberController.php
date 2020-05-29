<?php

namespace App\Http\Controllers;

use Request;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Category\Service\CategoryService as CategoryService;
use \App\Support\Menu as Menu;

use DB;
use Auth;

class MemberController extends Controller
{
    public function doEditprofile(Request $request)
    {
        $request = $request::all();
        
        $updateData = array();
        $updateData['phone'] = $request['phone'];
        $updateData['mobile'] = $request['mobile'];
        $updateData['addr'] = $request['addr'];
        if(isset($request['radio-edu']))
            $updateData['edu'] = $request['radio-edu'];
        if(isset($request['radio-skill']))
            $updateData['skill'] = $request['radio-skill'];
        if(isset($request['position']))
            $updateData['position'] = json_encode($request['position']);
        else
            $updateData['position'] = json_encode(array());

        try {
            DB::beginTransaction();

            UserService::update(Auth::user()->id, $updateData);

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

    public static function doGetFaimly(Request $request)
    {
        $request = $request::all();

        $data = UserService::getPersonnelViewInfo(Auth::user()->id);
        $data = json_decode(json_encode($data),true);

        return json_encode($data);
        exit();
    }

    public function MemberView(Request $request)
    {
    	$request = $request::all();

    	$data = UserService::getPersonnelViewInfo(Auth::user()->id);
    	$data = json_decode(json_encode($data),true);

    	$edus = CategoryService::getDataByType('edu');
    	foreach($edus as &$edu) {
    		if($edu['value'] == $data['edu'])
    			$edu['checked'] = 'checked';
    	}
    	unset($edu);

    	$skills = CategoryService::getDataByType('skill');
    	foreach($skills as &$skill) {
    		if($skill['value'] == $data['skill'])
    			$skill['checked'] = 'checked';
    	}
    	unset($skill);

    	$positions = CategoryService::getDataByType('position');
    	if($data['position'] != '') {

    		// $post_list = json_decode($data['position']);
    		$post_list = $data['position'];
	    	foreach($positions as &$position) {
	    		foreach($post_list as $list) {
	    			if($position['value'] == $list)
	    				$position['checked'] = 'checked';	
	    		}
	    	}
	    	unset($position);	
    	}

    	return view('BKMember')->with('data', $data)
    						   ->with('menu', Menu::setMenuList())
    						   ->with('userInfo', UserService::getUserBoxInfo())
                               ->with('upid', Auth::user()->id)
							   ->with('edus', $edus)
							   ->with('skills', $skills)
							   ->with('positions', $positions)
                               ->with('upid', Auth::id())
                               ->with('year', date('Y'));
    }
}
