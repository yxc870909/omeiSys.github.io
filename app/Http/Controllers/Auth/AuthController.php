<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use \App\Checker\AccountValidator as AccountValidator;
use \App\Support\AuthCode as AuthCode;
use Request;
use Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public static function login(Request $request)
    {
        $request = $request::all();
        $validator = AccountValidator::LoginValidator($request);
        
        if($validator->fails()) {
            return redirect('/')
                        ->withErrors($validator)
                        ->withInput();
        }
        else {
            $email = $request['account'];
            $password = $request['password']; 

            if (Auth::attempt(['uid' => $email, 'password' => $password, 'status' => 'active'])) {
                return redirect()->guest('/Calendar');
            }
            else {
                return redirect('/')
                        ->withErrors(array('password'=>'帳號或密碼輸入錯誤'))
                        ->withInput();
            }
        }
        
    }

    public static function logout()
    {
        Auth::logout();
        return redirect()->guest('/');
    }

    public static function authCode(Request $request)
    {
        AuthCode::Auth($request::all()['upid'], $request::all()['activation_code']);
        return redirect()->guest('/Calendar');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return \App\Models\User\Entity\User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
