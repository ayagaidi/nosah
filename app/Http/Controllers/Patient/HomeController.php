<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\doctor;
use App\Models\Patient;
use App\Models\PatientDietPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:patient');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('patient.home');
    }

    // Get doctors the patient is following or has appointments with
    public function doctorsList()
    {
        $patientId = \Illuminate\Support\Facades\Auth::id();

        $doctors = \App\Models\Appointment::with('doctor')
            ->where('patient_id', $patientId)
            ->distinct('doctor_id')
            ->get()
            ->pluck('doctor')
            ->filter();

        return $doctors;
    }
  public function  dietplan()
    {
        return view('patient.diet_plan');
    }


    public function showdietplan($plan_id)
    {
        $plan = PatientDietPlan::findOrFail($plan_id);
        $doctor = doctor::find($plan->prescribed_by);
        return view('patient.diet_planview', compact('plan','doctor'));
    }

     public function chat()
    {
        $appointments = \App\Models\Appointment::with(['doctor', 'clinic'])
            ->where('patient_id', \Illuminate\Support\Facades\Auth::id())
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('patient.chatt', compact('appointments'));
    }

     public function appointments()
    {
        $appointments = \App\Models\Appointment::with(['doctor', 'clinic'])
            ->where('patient_id', \Illuminate\Support\Facades\Auth::id())
            ->orderBy('scheduled_at', 'asc')
            ->get();

        return view('patient.appointment', compact('appointments'));
    }
     public function dietplanajax()
{
    $perPage = filter_var(request('per_page', 9), FILTER_VALIDATE_INT) ?: 9;
    $page = filter_var(request('page', 1), FILTER_VALIDATE_INT) ?: 1;

    $query = PatientDietPlan::with('doctor')
        ->where('patient_id', Auth::id())
        ->orderByDesc('date');

    $total = $query->count();
    $plans = $query->forPage($page, $perPage)->get();

    $data = $plans->map(function ($plan) {
        return [
                        'id' => $plan->id,

            'date' => $plan->date,
            'meal_type' => $plan->meal_type,
            'food_category' => $plan->food_category,
            'food_item' => $plan->food_item,
            'portion_size' => $plan->portion_size,
            'calories' => $plan->calories,
            'carbs' => $plan->carbs,
            'protein' => $plan->protein,
            'fat' => $plan->fat,
            'fiber' => $plan->fiber,
            'fluid_intake' => $plan->fluid_intake,
            'supplements' => $plan->supplements,
            'doctor' => optional($plan->doctor)->fullname ?? '-',
            'show' => '<a href="' . route('patient.diet_plan.showdietplan', [$plan->id]) . '" class="btn btn-info btn-sm" title="عرض التفاصيل"><i class="fa fa-eye"></i> عرض</a>',
        ];
    })->values();

    return response()->json([
        'data' => $data,
        'current_page' => $page,
        'per_page' => $perPage,
        'total' => $total,
        'last_page' => $perPage > 0 ? (int) ceil($total / $perPage) : 1,
    ]);
}

   
    

       
      public function showChangePasswordForm()
      {
          // وضع العنوان بالعربي مباشرة
          ActivityLogger::activity('تغيير كلمة المرور');
          return view('patient.change_form');
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
     


   

       public function show()
    {
        $patient = \App\Models\Patient::with('files')->findOrFail(Auth::user()->id);

        return view('patient.show')->with('patient', $patient);
    }
    
}
