<?php

namespace App\Http\Controllers;

use Request;
use DB;

class GroupController extends Controller
{
    public function doAddGroup(Request $request) {
    	$request = $request::all();

    	try {
    		DB::beginTransaction();

    		foreach ($request['data'] as $item) {

        		$g = new \App\Models\Group\Entity\Group;
        		$g->year = 	$item['year'];
        		$g->area = 	$item['area'];
                $g->group = $item['group'];
        		$g->type = 	'leader';
        		$g->upid = $item['leader'];
        		$g->save();

                if(isset($item['deputy_leader'])) {
                    $g = new \App\Models\Group\Entity\Group;
                    $g->year =  $item['year'];
                    $g->area =  $item['area'];
                    $g->group = $item['group'];
                    $g->type =  'deputy_leader';
                    $g->upid = $item['deputy_leader'];
                    $g->save();
                }			

                if(isset($item['member'])) {
                    foreach ($item['member'] as $m) {
                        $g = new \App\Models\Group\Entity\Group;
                        $g->year =  $item['year'];
                        $g->area =  $item['area'];
                        $g->group = $item['group'];
                        $g->type =  'member';
                        $g->upid = $m;
                        $g->save();
                    }
                }    		
    	}

    		DB::commit();
    		echo json_encode('success');
    	}
    	catch(Exception $e) {
			DB::rollback();
			echo json_encode($e);
			exit();
		}
    }
}
