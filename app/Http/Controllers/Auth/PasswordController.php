<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Auth;
use Validator;
use Hash;
use Request;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');

        $rules = ['email'=>'required|email',
              'password'=>'required'
              ];

        $input = array('email'=>'yxc870909gmail.com', 'password'=>'12345');
        // $validator = Validator::make($input, $rules);
        // echo $input['email'];
        // Auth::attempt(['email' => 'eSanford@King.biz', 'password' => Hash::check('12345', Hash::make('12345'))]);
        //Auth::attempt(['email' => 'eSanford@King.biz', 'password' => '12345']);
    }

    public static function ChangePsw(Request $request)
    {
        \App\Models\api\Member_ChangePsw::ChangePsw($request::all());
    }
}
