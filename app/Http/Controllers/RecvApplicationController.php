<?php

namespace App\Http\Controllers;

use Request;
use Auth;
use DB;
use \App\Models\Books\Service\RecvApplicationService as RecvApplicationService;

class RecvApplicationController extends Controller
{
    public function doAddRecvApplication(Request $request) 
    {
    	$request = $request::all();

    	if($request['count'] <= 0 || $request['count'] == '') {
            echo json_encode(array('count'=>'required'));
            exit();
        }

    	try {
    		DB::beginTransaction();

    		$sub_app = new \App\Models\Books\Entity\RecvApplication;
    		$sub_app->rbid = $request['id'];
    		$sub_app->upid = Auth::id();
    		$sub_app->count = $request['count'];
    		$sub_app->save();

    		DB::commit();

    		echo json_encode('success');
    		exit();
    	}catch(Exception $e){
            DB::rollback();
            echo json_encode($e);
            exit();
        }
    }

    public function doEditReceiveRecord(Request $request) 
    {
    	$request = $request::all();

    	if(isset($request['status']) && $request['status'] && isset($request['upid']) && $request['upid']) {
            
            if($request['status']=='finish') {

            	$updateData = array();
                $updateData['receiver'] = $request['upid'];
                $updateData['receive_date'] = date('yyyy-mm-dd');
                $updateData['status'] = $request['status'];

                try {
                    DB::beginTransaction();

                    RecvApplicationService::update($request['id'], $updateData); 

                    DB::commit();

                    echo json_encode('success');
                    exit();
                }catch(Exception $e){
                    DB::rollback();
                    echo json_encode($e);
                    exit();
                }
            }            
        }
        echo json_encode('');
        exit();
    }
}
