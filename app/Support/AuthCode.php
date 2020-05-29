<?php
namespace App\Support;
use \App\Models\User\Service\UserService as UserService;
use DB;

class AuthCode
{
	public static function Auth($upid, $code)
	{
		$filter = array(
			"a.id='".$upid."'",
			"a.activation_code='".$code."'"
		);
		$res = UserService::getUser(implode(' and ', $filter), 1, 9999);

		if(count($res) > 0) {
			try {
				DB::beginTransaction();

				$user = UserService::find($res[0]['id']);
				$user['status'] = 'active';
				$user->save();

				DB::commit();


			}catch(Exception $e) {
				DB::rollback();
			}
			
		}
	}
}