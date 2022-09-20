<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class   LoginController extends Controller
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
    protected $redirectTo ;
    protected function redirectTo( ) {
        if (Auth::check() && (Auth::User()->getRoleNames()[0] == 'Admin')) {
            return $this->redirectTo = '/home';
        }
        elseif (Auth::check() && (Auth::User()->getRoleNames()[0] == 'Service Executive')) {
            return $this->redirectTo = '/home';
        }
        elseif (Auth::check() && (Auth::User()->getRoleNames()[0] == 'Customer')) {
            return $this->redirectTo = '/user/dashboard';
        }
        elseif (Auth::check() && (Auth::User()->getRoleNames()[0] == 'Service Provider')) {
            return $this->redirectTo = '/user/dashboard';
        }
        else {
            return('/login');
        }
    }
    protected function credentials(Request $request)
    {
        //dd($request->all());
        if(is_numeric($request->get('phone'))){
            return ['phone'=>$request->get('phone'),'password'=>$request->get('password')];
        }
        elseif (filter_var($request->get('phone'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('phone'), 'password'=>$request->get('password')];
        }
        return ['username' => $request->get('phone'), 'password'=>$request->get('password')];
    }

    public function username()
    {
        return 'phone';
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
}
