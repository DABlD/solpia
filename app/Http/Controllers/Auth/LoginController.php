<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\AuditTrail;
use Browser;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // OVERRIDEN FUNCTIONS FROM AuthenticatesUsers
    protected function authenticated(Request $req, $user)
    {
        AuditTrail::create([
            'user_id'   => $user->id,
            'action'    => 'logged in.',
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);
    }

    public function logout(Request $req)
    {
        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => 'logged out.',
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);

        $this->guard()->logout();

        $req->session()->invalidate();

        return $this->loggedOut($req) ?: redirect('/');
    }
}
