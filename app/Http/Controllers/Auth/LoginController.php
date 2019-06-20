<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Class LoginController
 */
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
    protected $redirectTo = '/';

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
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }

    /**
     * After authentication
     *
     * @param Request $request Request
     * @param mixed   $user    CmsUser
     *
     * @return void
     */
    protected function authenticated(Request $request, $user) // phpcs:disable
    {
        $user->api_token = str_random(60);

        if($user->cross_month == null
            || (int)(new Carbon($user->cross_month))->format('m') < (int)Carbon::now()->format('m'))
        {
            $user->gift_count = 0;
            $user->cross_month = Carbon::now();
        }

        $user->save();
    }

    /**
     * Login method
     *
     * @param Request $request Request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        $user            = auth()->user();
        $user->api_token = null;
        $user->save();
        
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
