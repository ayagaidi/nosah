<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:doctor')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.doctor-login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.doctor-forgot-password');
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $doctor = \App\Models\doctor::where('email', $request->email)->first();

        if (!$doctor) {
            return back()->withErrors(['email' => 'البريد الإلكتروني غير موجود في النظام.']);
        }

        // Generate a new random password
        $plainPassword = \Illuminate\Support\Str::random(10);
        $doctor->password = bcrypt($plainPassword);
        $doctor->save();

        // Prepare WhatsApp message
        $message = "مرحباً دكتور " . $doctor->fullname . "%0A";
        $message .= "هذه كلمة المرور الجديدة الخاصة بك:%0A";
        $message .= "اسم المستخدم: " . $doctor->username . "%0A";
        $message .= "كلمة المرور: " . $plainPassword . "%0A";
        $message .= "رابط الدخول: " . route('doctor.login') . "%0A";

        // Prepare WhatsApp URL
        $phone = preg_replace('/[^0-9]/', '', $doctor->phonenumber);
        if (substr($phone, 0, 1) === '0') {
            $phone = '218' . substr($phone, 1);
        }
        $whatsappUrl = "https://wa.me/" . $phone . "?text=" . $message;

        return redirect()->away($whatsappUrl);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('doctor')->attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->intended(route('doctor.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::guard('doctor')->logout();
        return redirect()->route('doctor.login');
    }
}
