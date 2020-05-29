<?php
namespace App\Http\Controllers;

use Request;
use \App\Checker\TempleValidator as TempleValidator;
use \App\Models\Temple\Service\TempleService as TempleService;
use \App\Models\User\Service\UserService as UserService;
use \App\Models\Category\Service\CategoryService as CategoryService;
use \App\Models\User\Repository\UserRepository as UserRepository;
use \App\Support\PageSupport as PageSupport;
use \App\Support\LunarDate as LunarDate;
use \App\Support\Menu as Menu;

use Auth;
use DB;
use View;
use Redirect;

class TempleController extends Controller
{

    public function doAddTemple(Request $request)
    {
        $request = $request::all();

        $validator = \App\Checker\TempleValidator::TempleModelValidator($request);
        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }

        $upid = array();
        foreach(explode(',', $request['upid']) as $item) {
            $upid []= (int)$item;
        }

        try {
            DB::beginTransaction();
            $temple = new \App\Models\Temple\Entity\Temple;
            $temple->type = $request['temple_type'];
            $temple->name = $request['name'];
            $temple->area = $request['area'];
            $temple->addr = $request['addr'];
            $temple->phone = $request['phone'];
            $temple->upid = json_encode($upid);
            $temple->start_date = str_replace(array('年','月','日'), array('-','-',''), $request['start_date']);
            $temple->start_date2 = $request['yyy'].'年-'.$request['yy'].'-'.$request['mm'].'-'.$request['dd'];
            if(isset($request['bookstore']))
                $temple->bookstore = 'true';
            else
                $temple->bookstore = 'false';

            if(isset($request['training']))
                $temple->training = 'true';
            else
                $temple->training = 'false';

            $temple->save();
            DB::commit();
            echo json_encode('success');
            exit();
        }
        catch(Exception $e) {
            echo json_encode($e);
            exit();
        }
    }

    public function doEditTemple(Request $request)
    {
        $request = $request::all();
    	$validator = TempleValidator::TempleModelValidator($request);

        if($validator->fails()) {
            echo json_encode($validator->getMessageBag()->toArray());
            exit();
        }


        try {
            DB::beginTransaction();

            TempleService::update($request);

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

    public static function doGetTempleByArea(Request $request) 
    {
        $request = $request::all();
        $res = TempleService::getTempleByArea($request['area']);
        echo json_encode($res);
        exit();
    }

    public function doGetTemplInfo(Request $request)
    {
        $request = $request::all();

        $data = TempleService::getTempleInfoById($request['tid']); 
        
        echo json_encode($data);
        exit();
    }

    public function TempleView(Request $request)
    {
        $request = $request::all();

        //filter
        $filter = array();

        $Previous = '';
        $Next = '';
        if(!isset($request['page']) || !$request['page']) 
            $request['page'] = 1;

        if(isset($request['area']) && $request['area']) {
            $filter[] = "temple.area = '".$request['area']."'";
            $a = $request['area'];
        }
        else
            $request['area'] = '';        

        if(isset($request['temple_name']) && $request['temple_name']) {
            $filter[] = "temple.id = '".$request['temple_name']."'";
            $tn = $request['temple_name'];
        }
        else
            $request['temple_name'] = '';

        if(isset($request['temple_type']) && $request['temple_type']) {
            $filter[] = "temple.type = '".$request['temple_type']."'";
            $tt = $request['temple_type'];
        }
        else
            $request['temple_type'] = '';
        
        if(isset($request['search_type']) && $request['search_type']) {
            if($request['search_type'] == 'name'){

                $res = \App\Models\User\Entity\User::whereRaw("concat(first_name, last_name) like '%".$request['search_word']."%'")->get();

                $upids = array();
                if(count($res) > 0) {
                    foreach($res as $item) {
                        $upids[] = $item['id'];    
                    }                     
                }

                $f = array();
                foreach($upids as $item) {
                    $f[] = "upid like '[".$item.",%'";
                    $f[] = "upid like '%,".$item.",%'";
                    $f[] = "upid like '%,".$item."]'";    
                    $f[] = "upid like '[".$item."]'";   
                }
                $filter[] = "(".implode(' or ', $f).")";
            }
            if($request['search_type'] == 'addr')
                $filter[] = "temple.addr like '%".$request['search_word']."%'";
        }
        else {
            $request['search_type'] = '';
            $request['search_word'] = '';
        }

        $filter = count($filter) > 0 ? implode(' and ', $filter) : "1";

        //get data
        $temples = TempleService::getTempleList(Auth::id(), $filter, 15, $request['page']);

        //get option
        $area = CategoryService::get_DDL(isset($a) ? $a : '', 'area', '選擇佛堂區域');
        $temple_name = TempleService::getTempleName_DDL(isset($tn) ? $tn : '');
        $temple_type = CategoryService::get_DDL(isset($tt) ? $tt : '', 'temple_type', '選擇佛壇性質');
        $optionType = TempleService::getOptionType(isset($request['search_type']) ? $request['search_type'] : '');

        //page
        $pageCount = TempleService::getPageCount($filter);

        if($request['page'] == 1)
            $Previous = 'disabled';
        if($request['page'] == $pageCount)
            $Next = 'disabled';

        $linkParam = 'area='.$request['area'].
                    '&temple_name='.$request['temple_name'].
                    '&temple_type='.$request['temple_type'].
                    '&search_type='.$request['search_type'].
                    '&search_word='.$request['search_word'];
        $page = PageSupport::getPageArrayStructure('/Temple', $pageCount, $request['page'], $linkParam);

        
        return view('BKTemple')->with('menu', Menu::setMenuList('Temple'))
                        ->with('userInfo', UserService::getUserBoxInfo())
                        ->with('btnShow', UserService::UserTypeValidator('AddTemple', Auth::user()->type))
                        ->with('editShow', UserService::UserTypeValidator('EditTemple', Auth::user()->type))
                        
                        ->with('temples', $temples)
                        ->with('page', $page)
                        ->with('pageCount', $pageCount)
                        ->with('Previous', $Previous)
                        ->with('Next', $Next)

                        ->with('areas', $area)
                        ->with('operating', $temple_name)
                        ->with('temple_types', $temple_type)
                        ->with('optionType', $optionType)
                        ->with('lunar_month', LunarDate::getLunarMonth())
                        ->with('lunar_day', LunarDate::getLunarDay())
                        ->with('lunar_hour', LunarDate::getLunarHour());
    }
}
