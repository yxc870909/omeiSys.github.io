<?php

namespace App\Models\Model;
use \App\Models\User\Service\UserService as UserService;
use DB;

class AuthCode
{
	public static function Auth($upid, $code)
	{
		$filter = array(
			'id='.$upid,
			'activation_code='.$code
		);
		$res = UserService::getUser(implode(' and ', $filter), 1, 9999);
		// $res = 		$newPsw = Hash::make($request['newPsw']);
		// \App\Models\User\Entity\User::where('id', '=', $upid)
		// 							  ->where('activation_code', '=', $code)->get();
		if(count($res) > 0) {
			try {
				DB::beginTransaction();

				$user = UserService::find($res[0]['id']);
				// $user = 		$newPsw = Hash::make($request['newPsw']);
				\App\Models\User\Entity\User::find($res[0]['id']);
				$user['status'] = 'active';
				$user->save();

				DB::commit();


			}catch(Exception $e) {
				DB::rollback();
			}
			
		}
	}
}