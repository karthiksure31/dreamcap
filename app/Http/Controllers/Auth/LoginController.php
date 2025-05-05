<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected function redirectTo()
    {
        if (Auth()->user()->role_id == 1) {
            return route('admin.dashboard');
        } elseif (Auth()->user() == 2) {
            return route('user.dashboard');
        }
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
    public function login(Request $request)
    {
        $input = $request->all();

        // Validate the login request
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Attempt to authenticate the user
        $remember = $request->has('remember') ? true : false; // Check if "Remember Me" is checked

        if (auth()->attempt(['email' => $input['email'], 'password' => $input['password']], $remember)) {

            if (auth()->user()->role_id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role_id == 2) {
                return redirect()->route('user.dashboard');
            }
        } else {
            return redirect()->route('login')->with('error', 'Email and password are incorrect');
        }
    }
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }
}
