<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\doctor;
use App\Models\Specializations;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\DoctorCreated;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specializations = Specializations::all(); // Fetch specializations
        ActivityLogger::activity('عرض جميع الأطباء');
        return view('dashbord.doctors.index', compact('specializations')); // Pass to view
    }

    public function doctors()
    {
        $doctors = doctor::with('specializations', 'clinics')->orderBy('created_at', 'DESC');
        return datatables()->of($doctors)
            ->addColumn('edit', function ($doctor) {
                $doctor_id = encrypt($doctor->id);
                return '<a style="color: #f97424;" href="' . route('doctors/edit', $doctor_id) . '"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('changeStatus', function ($doctor) {
                $doctor_id = encrypt($doctor->id);
                return '<a href="' . route('doctors/changeStatus', $doctor_id) . '"><i class="fa fa-refresh"></i></a>';
            })
            ->rawColumns(['edit', 'changeStatus'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specializations = Specializations::all(); // Fetch specializations
        $clinics = Clinic::all(); // Fetch clinics
        ActivityLogger::activity('عرض صفحة إضافة طبيب جديد');
        return view('dashbord.doctors.create', compact('specializations', 'clinics')); // Pass clinics to view
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'fullname.required' => 'اسم الطبيب مطلوب.',
            'username.required' => 'اسم المستخدم مطلوب.', // Add username message
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'phonenumber.required' => 'رقم الهاتف مطلوب.', // Add phonenumber message
            'phonenumber.regex' => 'رقم الهاتف يجب أن يكون مكونًا من 10 أرقام بالضبط.',
            'specializations_id.required' => 'التخصص مطلوب.',
            'cv.mimes' => 'يجب أن يكون ملف السيرة الذاتية PDF أو DOC أو DOCX.',
            'cv.max' => 'يجب ألا يتجاوز حجم السيرة الذاتية 5 ميجابايت.',
        ];
        $this->validate($request, [
            'fullname' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'unique:doctors'], // Add username validation
            'email' => [
                'required',
                'email',
                'unique:doctors',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'phonenumber' => ['required', 'regex:/^\d{10}$/'], // Enforce exactly 10 digits
            'specializations_id' => ['required', 'exists:specializations,id'],
            'image' => ['nullable', 'image'],
            'clinics' => ['nullable', 'array'], // Validate clinics
            'clinics.*' => ['exists:clinics,id'], // Ensure each clinic exists
            'cv' => ['nullable', 'mimes:pdf,doc,docx', 'max:5120'],
        ], $messages);

        try {
            $doctor = DB::transaction(function () use ($request, &$plainPassword) {
                $doctor = new Doctor();
                $doctor->fullname           = $request->fullname;
                $doctor->username           = $request->username;
                $doctor->email              = $request->email;
                $doctor->phonenumber        = $request->phonenumber;
                $doctor->specializations_id = $request->specializations_id;
                $doctor->image              = $request->file('image')
                    ? $request->file('image')->store('doctors')
                    : null;
                // حفظ السيرة الذاتية إن وجدت
               

                // 1) generate & hash
                $plainPassword         = Str::random(10);
                $doctor->password      = bcrypt($plainPassword);

                $doctor->save();
                $doctor->clinics()->sync($request->clinics);
                 if ($request->file('cv')) {
            $cvFile = $request->file('cv');
            $cvName = 'cv' . time() . '.pdf';
             
                         $cvFile->move(base_path('../public_html/doctors/cv'), $cvName);

            // $cvFile->move(public_path('doctors/cv'), $cvName);
            $doctor->cv = $cvName;
            $doctor->save(); // Save CV filename after upload
        }
                return $doctor;

              
            });

            // 2) dispatch email *after* transaction commits
            Mail::to($request->email)
                ->send(new DoctorCreated($doctor, $plainPassword));

            Alert::success('تمت إضافة الطبيب وإرسال بيانات الدخول بنجاح.');
            ActivityLogger::activity('تمت إضافة طبيب جديد وإرسال بيانات الدخول.');
            return redirect()->route('doctorss');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity('فشل في إضافة طبيب جديد.');

            return redirect()->route('doctorss');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $doctor_id = $id;
        $doctor = doctor::with('specializations', 'clinics')->findOrFail($doctor_id);
        return view('dashbord.doctors.show', compact('doctor'));
    }

    public function sendLoginCredentials($id)
    {
        $doctor_id = $id;
        $doctor = doctor::findOrFail($doctor_id);

        // Generate a new random password
        $plainPassword = \Illuminate\Support\Str::random(10);
        $doctor->password = bcrypt($plainPassword);
        $doctor->save();

        // Send email with login credentials
        try {
            \Illuminate\Support\Facades\Mail::to($doctor->email)
                ->send(new \App\Mail\DoctorCreated($doctor, $plainPassword));

            \RealRashid\SweetAlert\Facades\Alert::success('تم إرسال بيانات الدخول للطبيب بنجاح.');
        } catch (\Exception $e) {
            \RealRashid\SweetAlert\Facades\Alert::error('فشل في إرسال بيانات الدخول للطبيب: ' . $e->getMessage());
        }

        return redirect()->route('doctorss');
    }

    public function sendLoginCredentialsWhatsApp($id)
    {
        $doctor_id = $id;
        $doctor = doctor::findOrFail($doctor_id);

        // Generate a new random password
        $plainPassword = \Illuminate\Support\Str::random(10);
        $doctor->password = bcrypt($plainPassword);
        $doctor->save();

        // Prepare WhatsApp message
        $message = "مرحباً دكتور " . $doctor->fullname . "%0A";
        $message .= "هذه بيانات الدخول الخاصة بك:%0A";
        $message .= "اسم المستخدم: " . $doctor->username . "%0A";
        $message .= "كلمة المرور: " . $plainPassword . "%0A";
        $message .= "رابط الدخول: " . route('doctor.login') . "%0A"; // Assuming route name for doctor login page

        // Prepare WhatsApp URL
        $phone = preg_replace('/[^0-9]/', '', $doctor->phonenumber); // Remove non-numeric chars
        if (substr($phone, 0, 1) === '0') {
            $phone = '218' . substr($phone, 1); // Assuming Saudi Arabia country code if number starts with 0
        }
        $whatsappUrl = "https://wa.me/" . $phone . "?text=" . $message;

        return redirect()->away($whatsappUrl);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($doctor)
    {
        $doctor_id = decrypt($doctor);
        $doctor = doctor::find($doctor_id);
        $specializations = Specializations::all();
        $clinics = Clinic::all();
        ActivityLogger::activity('عرض صفحة تعديل طبيب');
        return view('dashbord.doctors.edit', compact('doctor', 'specializations', 'clinics'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $doctor)
    {
        $doctor_id = decrypt($doctor);

        $messages = [
            'fullname.required' => 'اسم الطبيب مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'phonenumber.required' => 'رقم الهاتف مطلوب.',
            'phonenumber.regex' => 'رقم الهاتف يجب أن يكون مكونًا من 10 أرقام بالضبط.',
            'specializations_id.required' => 'التخصص مطلوب.',
            'cv.mimes' => 'يجب أن يكون ملف السيرة الذاتية PDF أو DOC أو DOCX.',
            'cv.max' => 'يجب ألا يتجاوز حجم السيرة الذاتية 5 ميجابايت.',
        ];
        $this->validate($request, [
            'fullname' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email'],
            'phonenumber' => ['required', 'regex:/^\d{10}$/'],
            'specializations_id' => ['required', 'exists:specializations,id'],
            'image' => ['nullable', 'image'],
            'clinics' => ['nullable', 'array'],
            'clinics.*' => ['exists:clinics,id'],
            'cv' => ['nullable', 'mimes:pdf,doc,docx', 'max:5120'],
        ], $messages);

        try {
            DB::transaction(function () use ($request, $doctor_id) {
                $doctor = doctor::find($doctor_id);
                $doctor->fullname = $request->fullname;
                $doctor->username = $request->username;
                $doctor->email = $request->email;
                $doctor->phonenumber = $request->phonenumber;
                $doctor->specializations_id = $request->specializations_id;
                if ($request->file('image')) {
                    $fileObject = $request->file('image');
                    $image = "serviceprovider_" . time() . ".jpg";
                    $fileObject->move('images/serviceprovider/', $image);
                    $doctor->image = $image;
                }
                if ($request->file('cv')) {
                    $cvPath = $request->file('cv');
                
                    $doctors = "cv" . time() . ".pdf";
                    $cvPath->move('doctors/cv/', $doctors);
                    $doctor->cv = $doctors;
                }
                $doctor->save();
                $doctor->clinics()->sync($request->clinics);
            });

            Alert::success('تم تعديل الطبيب بنجاح.');
            ActivityLogger::activity('تم تعديل طبيب بنجاح.');

            return redirect()->route('doctorss');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity('فشل تعديل طبيب.');

            return redirect()->route('doctorss');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(doctor $doctor)
    {
        //
    }

    public function changeStatus($id)
    {
        $doctor_id = decrypt($id);
        $doctor = doctor::find($doctor_id);

        try {
            DB::transaction(function () use ($doctor) {
                $doctor->active = $doctor->active == 1 ? 0 : 1;
                $doctor->save();
            });

            ActivityLogger::activity($doctor->fullname . ' تم تغيير حالة الطبيب بنجاح.');
            Alert::success('تم تغيير حالة الطبيب بنجاح.');

            return redirect()->route('doctorss');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($doctor->fullname . ' فشل في تغيير حالة الطبيب.');

            return redirect()->route('doctorss');
        }
    }
}
