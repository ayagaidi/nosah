<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('doctor.home');
    }



    public function show($id)
    {
        $doctor_id = decrypt($id);
        $doctor = doctor::find($doctor_id);

        return view('doctor.profile')->with('user', $doctor);
    }

    public function showChangePasswordForm()
    {
        // وضع العنوان بالعربي مباشرة
        ActivityLogger::activity('تغيير كلمة المرور');
        return view('doctor.change_form');
    }

    public function changePassword(Request $request)
    {
        $messages = [
            'current-password.required' => 'كلمة المرور الحالية مطلوبة',
            'new-password.required' => 'كلمة المرور الجديدة مطلوبة',
            'new-password-confirm.required' => 'تأكيد كلمة المرور الجديدة مطلوب',
        ];

        $this->validate($request, [
            'current-password' => ['required', 'string', 'min:6'],
            'new-password' => ['required', 'string', 'min:6'],
            'new-password-confirm' => ['required', 'same:new-password', 'string', 'min:6'],
        ], $messages);
        if (!(Hash::check($request->input('current-password'), Auth::user()->password))) {
            Alert::warning('كلمة المرور الحالية غير صحيحة');
            return redirect()->back();
        }
        //Change Password
        $user = Auth::user();
        $user->password = Hash::make($request->input('new-password'));
        $user->save();
        Alert::success('تم تغيير كلمة المرور بنجاح');
        return redirect()->back();
    }


    public function searchPatient(Request $request)
    {

        $request->validate([
            'patient_id' => 'required|string',
        ]);
        $patient = Patient::where('patient_number', $request->input('patient_id'))->first();
        if (!$patient) {
            Alert::error('خطأ', 'المريض غير موجود');
            return back()->withErrors(['patient_id' => 'المريض غير موجود']);
        }
        Alert::success('نجاح', 'تم العثور على المريض بنجاح.');

        return view('doctor.home', ['patient' => $patient]);
    }
}
