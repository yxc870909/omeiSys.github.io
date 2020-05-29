<?php
namespace App\Models\api;
use Hash;
use Auth;
use DB;

class Member_ChangePsw
{
	public static function ChangePsw($request)
	{	
		// if(!Auth::check()) {
		// 	Auth::attempt(['email' => 'Itzel62@Bernier.com', 'password' => '12345']);
		// }

		// if(!Auth::check())
		// 	exit();

		//檢查舊密碼是否正確
		$_user = 		$newPsw = Hash::make($request['newPsw']);
		\App\Models\User\Entity\User::where('email', '=', Auth::user()->email)->get();
		$user  = $_user[0];
		$checkOldPassword = Hash::check($request['oldPsw'], $user['password']);
		if(!$checkOldPassword) {
			echo json_encode('old passwor is error');
			exit();
		}

		//驗證新密碼是否重複
		$checkNewPassword = Hash::check($request['newPsw'], $user['password']);
		if($checkNewPassword){
			echo json_encode('Repeat with old password');
			exit();
		}

		//驗證確認新密碼
		if($request['newPsw'] != $request['confirmPsw']){
			echo json_encode('confirm passwor is error');
			exit();
		}

		//update password
		$newPsw = Hash::make($request['newPsw']);
		try {
			DB::beginTransaction();
					$newPsw = Hash::make($request['newPsw']);
			\App\Models\User\Entity\User::where('email', '=', Auth::user()->email)->update(array('password'=>$newPsw));
			DB::commit();
			echo json_encode('success');
			exit();
		}
		catch(Exception $e) {
			echo json_encode($e);
			DB::rollback();
			exit();
		}
	}
}
