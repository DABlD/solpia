<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\AuditTrail;
use App\User;
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
    public function authenticated(Request $req, $user)
    {
        AuditTrail::create([
            'user_id'   => $user->id,
            'action'    => 'logged in',
            'ip'        => $req->getClientIp(),
            'hostname'  => gethostname(),
            'device'    => Browser::deviceFamily(),
            'browser'   => Browser::browserName(),
            'platform'  => Browser::platformName()
        ]);
    }

    public function showLoginForm(Request $req)
    {
        return view('auth.login');
    }

    public function logout(Request $req)
    {
        AuditTrail::create([
            'user_id'   => auth()->user()->id,
            'action'    => 'logged out',
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

    public function login(Request $request) {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) 
        {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            $message = "";

            if($user->role == 'Cadet' && !Str::startsWith($request->getClientIp(), '192.168')){
                $message = "No authorization outside.";
                // dd($request->getClientIp());
                AuditTrail::create([
                    'user_id'   => $user->id,
                    'action'    => 'tried to access outside',
                    'ip'        => $request->getClientIp(),
                    'hostname'  => gethostname(),
                    'device'    => Browser::deviceFamily(),
                    'browser'   => Browser::browserName(),
                    'platform'  => Browser::platformName()
                ]);
            }
            elseif(!$user->status){
                $message = "Wait for the admin to confirm your account.";
            }

            if ($message == "" && $this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            } 
            else {

                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['status' => $message]);
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function credentials(Request $request)
    {
        $field = $this->field($request);

        return [
            $field => $request->get($this->username()),
            'password' => $request->get('password'),
        ];
    }

    public function field(Request $request)
    {
        $email = $this->username();

        return filter_var($request->get($email), FILTER_VALIDATE_EMAIL) ? $email : 'username';
    }

    protected function validateLogin(Request $request)
    {
        $field = $this->field($request);

        $messages = ["{$this->username()}.exists" => 'This account is not yet registered'];

        $this->validate($request, [
            $this->username() => "required|exists:users,{$field}",
            'password'  => 'required',
        ], $messages);
    }
}
