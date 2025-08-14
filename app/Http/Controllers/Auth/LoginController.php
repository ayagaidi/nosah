<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

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
    // protected $maxAttempts = 10; // Default is 5
    // protected $decayMinutes = 10; 

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function refreshCaptcha()
    {
        return response()->json(['captcha'=> captcha_img()]);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Only Login Active
        if ($this->guard()->validate($this->credentials($request))) {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active
            if ($user->active && $this->attemptLogin($request)) {
                // Send the normal successful login response
                ActivityLogger::activity("تسجيل دخول بنجاح");

                return $this->sendLoginResponse($request);
            } else {
                // Increment the failed login attempts and redirect back to the
                // login form with an error message.
                ActivityLogger::activity(" فشل تسجيل دخول ");

                $this->incrementLoginAttempts($request);
                return redirect()
                    ->back()
                    ->withInput($request->only($this->username(), 'remember'))
                    ->withErrors(['email' => 'حسابك معطل قم بالاتصال بمدير النظام']);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function logout(Request $request)
    {

        $this->guard()->logout();

        $request->session()->invalidate();


        return $this->loggedOut($request) ?:

        redirect('login');
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $User = \App\Models\User::where('email', $request->email)->first();

        if (!$User) {
            return back()->withErrors(['email' => 'البريد الإلكتروني غير موجود في النظام.']);
        }

        // Generate a new random password
        $plainPassword = \Illuminate\Support\Str::random(10);
        $User->password = bcrypt($plainPassword);
        $User->save();

        // Prepare WhatsApp message
        $message = "مرحباً ادمن " . $User->fullname . "%0A";
        $message .= "هذه كلمة المرور الجديدة الخاصة بك:%0A";
        $message .= "اسم المستخدم: " . $User->username . "%0A";
        $message .= "كلمة المرور: " . $plainPassword . "%0A";
        $message .= "رابط الدخول: " . route('login') . "%0A";

        // Prepare WhatsApp URL
        $phone = preg_replace('/[^0-9]/', '', $User->phonenumber);
        if (substr($phone, 0, 1) === '0') {
            $phone = '218' . substr($phone, 1);
        }
        $whatsappUrl = "https://wa.me/" . $phone . "?text=" . $message;

        return redirect()->away($whatsappUrl);
    }
}
