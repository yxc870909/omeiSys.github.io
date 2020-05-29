<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// use App\Http\Requests;
use Request;

class SubApplicationController extends Controller
{
    public function doAddSubApplication(Request $request) 
    {
    	\App\Models\Entity\SubApplication::doAddSubApplication($request::all());
    }

    public function doEditSubscriptionRecord(Request $request) 
    {
    	// if(isset($request['status']) && $request['status'] && isset($request['upid']) && $request['upid']) {
            
     //        if($request['status']=='finish') {

     //            try {
     //                DB::beginTransaction();

     //                $updateData = array();
     //                $updateData['receiver'] = $request['upid'];
     //                $updateData['receive_date'] = date('yyyy-mm-dd');
     //                $updateData['status'] = $request['status'];

     //                SubApplication::where('id', '=', $request['spid'])->update($updateData);                
     //                DB::commit();

     //                echo json_encode('success');
     //                exit();
     //            }catch(Exception $e){
     //                DB::rollback();
     //                echo json_encode($e);
     //                exit();
     //            }
     //        }            
     //    }
     //    echo json_encode('');
     //    exit();
        
    	// \App\Models\Entity\SubApplication::doEditSubscriptionRecord($request::all());
    }
}
