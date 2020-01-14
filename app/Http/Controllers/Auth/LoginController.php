<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Show the application's login form for teacher.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginFormForTeacher()
    {
        return view('auth.login_teacher');
    }

    protected function authenticated(\Illuminate\Http\Request $request, $user)
    {
        if ($request->role == 'admin') {
            $redirector = '/login';
        } else if ($request->role == 'teacher') {
            $redirector = '/login/teacher';
        }

        if ($request->role !== $user->role) {
            $this->guard()->logout();

            $request->session()->invalidate();

            return $this->loggedOut($request) ?: redirect($redirector);
        }

        if ($user->role == 'admin') {
            return redirect('/');
        } else {
            return redirect()->route('training.test');
        }
    }
}
