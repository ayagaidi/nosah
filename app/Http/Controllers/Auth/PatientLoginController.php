<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:patient')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.patient-login');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.patient-forgot-password');
    }

    public function handleForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $patient = \App\Models\Patient::where('email', $request->email)->first();

        if (!$patient) {
            return back()->withErrors(['email' => 'البريد الإلكتروني غير موجود في النظام.']);
        }

        // Generate a new random password
        $plainPassword = \Illuminate\Support\Str::random(10);
        $patient->password = bcrypt($plainPassword);
        $patient->save();

        // Prepare WhatsApp message
        $message = "مرحباً " . $patient->fullname . "%0A";
        $message .= "هذه كلمة المرور الجديدة الخاصة بك:%0A";
        $message .= "اسم المستخدم: " . $patient->username . "%0A";
        $message .= "كلمة المرور: " . $plainPassword . "%0A";
        $message .= "رابط الدخول: " . route('patient.login') . "%0A";

        // Prepare WhatsApp URL
        $phone = preg_replace('/[^0-9]/', '', $patient->phonenumber);
        if (substr($phone, 0, 1) === '0') {
            $phone = '218' . substr($phone, 1);
        }
        $whatsappUrl = "https://wa.me/" . $phone . "?text=" . $message;

        return redirect()->away($whatsappUrl);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('patient')->attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ])) {
            $request->session()->regenerate();
            return redirect()->intended(route('patient.dashboard'));
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('patient.login');
    }
}
