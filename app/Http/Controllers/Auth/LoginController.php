<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use DB;
use Auth;
use Config;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/switchshop';
	protected function redirectTo(){
		return '/switchshop';
	}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
	
	public function username(){
		return 'username';
	}

	protected function authenticated($request) {

		if(Auth::attempt(['username' => $request->username, 'password' => $request->password,'LOCK_FLG' => 0])) {
			$user = DB::table('MST_USER')->where('username', $request->username)->first();
			
			$data = array();
			$data['id'] = $user->id;
			$data['email'] = $user->email;
			$data['name'] = $user->name;
			$data['username'] = $user->username;
			$data['user_level'] = $user->user_level;
			$data['shop_fc_no'] = unserialize($user->shop_fc_no);
			$data['updater'] = $user->updated_at;
			
			session()->put('users', $data);
		} else {

			Auth::logout();
			return redirect('login')->withErrors([
				'username' => 'Your account has been disabled, Please contact your administrator.',
			]);
		}

	}
	
	// protected function authenticated($request){
	// 	// echo '<pre>';var_dump(Auth::check());echo '</pre>';die();
	// 	// ['username' => $request->username, 'password' => $request->password]
	// 	if (Auth::check()) {
	// 		$user = DB::table('MST_USER')->where('username', $request->username)->first();

	// 		$data = array();
	// 		$data['id'] = $user->id;
	// 		$data['email'] = $user->email;
	// 		$data['name'] = $user->name;
	// 		$data['username'] = $user->username;
	// 		$data['user_level'] = $user->user_level;
	// 		$data['shop_fc_no'] = unserialize($user->shop_fc_no);
			
	// 		session()->put('users', $data);
	// 	}else{
	// 		return redirect('login')->withErrors([
	// 			'username' => 'The Username or the password is invalid. Please try again.',
	// 		]);
	// 	}
	// }
	
	protected function getLogout(){
        $this->auth->id();
		// Session::put('id', '');
		// Session::put('email', '');
		// Session::put('name', '');
		// Session::put('username', '');
		// Session::put('user_level', '');
		// session()->flush();
		session()->forget('users');

        return redirect('login');
    }
}
