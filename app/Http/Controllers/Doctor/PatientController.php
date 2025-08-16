<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:doctor');
    }

    public function index()
    {
        return view('doctor.patient.index');
    }

    public function patients()
    {
        $patients = Patient::where('doctors_id',Auth::user()->id)->orderBy('created_at', 'DESC');
        return datatables()->of($patients)
            ->addColumn('edit', function ($patient) {
                $patient_id = encrypt($patient->id);
                return '<a style="color: #f97424;" href="' . route('doctor.patients.edit', $patient_id) . '"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('changeStatus', function ($patient) {
                $patient_id = encrypt($patient->id);
                return '<a href="' . route('doctor.patients.changeStatus', $patient_id) . '"><i class="fa fa-refresh"></i></a>';
            })
            ->addColumn('show', function ($patient) {
                $patient_id = encrypt($patient->id);
                return '<a href="' . route('doctor.patients.show', $patient_id) . '"><i class="fa fa-file"></i></a>';
            })
            ->addColumn('sendWhatsApp', function ($patient) {
                $patient_id = encrypt($patient->id);
                $url = route('doctor.patients.sendWhatsApp', $patient_id);
                return '<a target="_blank" href="' . $url . '" title="إرسال بيانات المريض عبر واتساب"><i class="fa fa-whatsapp"></i></a>';
            })
            ->rawColumns(['edit', 'changeStatus', 'show', 'sendWhatsApp'])
            ->make(true);
    }

    public function create()
    {
        return view('doctor.patient.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'full_name.required'  => 'اسم المريض مطلوب.',
            'email.required'      => 'البريد الإلكتروني مطلوب.',
            'email.email'         => 'صيغة البريد الإلكتروني غير صحيحة.',
            'dob.required'        => 'تاريخ الميلاد مطلوب.',
            'gender.required'     => 'الجنس مطلوب.',
            'weight.numeric'      => 'الوزن يجب أن يكون رقمًا.',
            'height.numeric'      => 'الطول يجب أن يكون رقمًا.',
            'contact_number.regex' => 'رقم التواصل يجب أن يكون 10 أرقام ويبدأ بأحد القيم التالية: 094, 095, 093, 092, 091.',
            'patient_files.*.title.required_with' => 'عنوان الملف مطلوب عند رفع الملف.',
            'patient_files.*.file.mimes'          => 'نوع الملف يجب أن يكون PDF أو صورة (jpeg, png).',
        ];
        $rules = [
            'full_name'       => ['required','string','max:100'],
            'email'           => ['required','email','max:100'],
            'dob'             => ['required','date'],
            'gender'          => ['required','in:M,F'],
            'weight'          => ['nullable','numeric'],
            'height'          => ['nullable','numeric'],
            'contact_number'  => ['required', 'regex:/^(094|095|093|092|091)\d{7}$/'],
            'address'         => ['nullable','string'],
            'medical_history' => ['nullable','string'],
            'allergies'       => ['nullable','string'],
            'medications'     => ['nullable','string'],
            'patient_files'              => ['nullable','array'],
            'patient_files.*.title'      => ['required_with:patient_files.*.file','string','max:150'],
            'patient_files.*.file'       => ['required_with:patient_files.*.title','file','mimes:pdf,jpeg,png','max:2048'],
        ];


        $validated = $request->validate($rules, $messages);

        DB::beginTransaction();
        try {
            // إنشاء رقم تسلسلي فريد للمريض
            $lastPatient = Patient::orderBy('id', 'desc')->first();
            $nextNumber = $lastPatient ? ((int)filter_var($lastPatient->patient_number, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
            $patientNumber = 'PAT' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

            // إنشاء كلمة مرور عشوائية
            $randomPassword = \Illuminate\Support\Str::random(8);

            // إنشاء سجل المريض
            $patient = Patient::create([
                'patient_number'   => $patientNumber,
                'full_name'        => $validated['full_name'],
                'email'            => $validated['email'],
                'dob'              => $validated['dob'],
                'doctors_id'=>Auth::user()->id,
                'password'         => bcrypt($randomPassword), // تشفير كلمة المرور
                'gender'           => $validated['gender'],
                'contact_number'   => $validated['contact_number'] ?? null,
                'address'          => $validated['address'] ?? null,
                'medical_history'  => $validated['medical_history'] ?? null,
                'allergies'        => $validated['allergies'] ?? null,
                'medications'      => $validated['medications'] ?? null,
                'weight'           => $validated['weight'] ?? null,
                'height'           => $validated['height'] ?? null,
                'active'           => 1,
            ]);

            if (!empty($validated['patient_files'])) {
    foreach ($validated['patient_files'] as $fileInput) {
        $fileObject = $fileInput['file'];

        // Generate a custom file name
        $fileName = 'patient_' . time() . '_' . uniqid() . '.' . $fileObject->getClientOriginalExtension();

        // Move the file to public storage (e.g., public/patient_files)
        $destinationPath =  base_path('../public_html/patient_files');
        $fileObject->move($destinationPath, $fileName);

        // Save the record in the database
        PatientFile::create([
            'patient_id' => $patient->id,
            'title'      => $fileInput['title'],
            'file_path'  => 'patient_files/' . $fileName,  // Relative path for access
            'type'       => $fileInput['type'] ?? null,
        ]);
    }
}

            // إرسال بريد إلكتروني للمريض
            Mail::raw(
                "مرحباً {$patient->full_name},\n\nتم تسجيلك في نظام nosah.\n\nبيانات الدخول:\nالبريد الإلكتروني: {$patient->email}\nكلمة المرور: {$randomPassword}\nرقم المريض: {$patient->patient_number}\n\nيرجى تغيير كلمة المرور بعد تسجيل الدخول.",
                function($message) use ($patient) {
                    $message->to($patient->email)
                            ->subject('بيانات تسجيل الدخول لنظام nosah');
                }
            );

            DB::commit();

            Alert::success('نجاح', 'تمت إضافة المريض بنجاح وتم إرسال بيانات الدخول إلى بريده الإلكتروني.');
            return redirect()->route('doctor.patients');

        } catch (\Throwable $e) {
            DB::rollback();
            Alert::error('خطأ', 'لم يتم إضافة المريض: '.$e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function edit($patient)
    {
        $patient_id = decrypt($patient);
        $patient = Patient::with('files')->find($patient_id);
        return view('doctor.patient.edit', compact('patient'));
    }

   public function update(Request $request, $patient)
{
    $patient_id = decrypt($patient);

    // Validation rules
    $rules = [
        'full_name'    => 'required|string|max:255',
        'email'        => 'required|email',
        'dob'          => 'required|date',
        'gender'       => 'nullable',
        'weight'       => 'nullable|numeric',
        'height'       => 'nullable|numeric',
        'contact_number' => 'nullable|string|max:20',
        'address'        => 'nullable|string',
        'medical_history' => 'nullable|string',
        'allergies'       => 'nullable|string',
        'medications'     => 'nullable|string',
        'patient_files.*.file' => 'nullable|file|max:5120', // max 5MB
        'patient_files.*.title' => 'nullable|string|max:255',
        'patient_files.*.type' => 'nullable|string|max:50',
    ];

    $messages = [
        'full_name.required' => 'اسم المريض مطلوب.',
        'email.required'     => 'البريد الإلكتروني مطلوب.',
        'email.email'        => 'صيغة البريد الإلكتروني غير صحيحة.',
        'dob.required'       => 'تاريخ الميلاد مطلوب.',
        'gender.required'    => 'الجنس مطلوب.',
    ];

    $validated = $request->validate($rules, $messages);

    try {
        DB::transaction(function () use ($validated, $patient_id) {
            $patient = Patient::findOrFail($patient_id);

            $patient->update([
                'full_name'       => $validated['full_name'],
                'email'           => $validated['email'],
                'dob'             => $validated['dob'],
                'gender'          => $validated['gender'],
                'weight'          => $validated['weight'] ?? null,
                'height'          => $validated['height'] ?? null,
                'contact_number'  => $validated['contact_number'] ?? null,
                'address'         => $validated['address'] ?? null,
                'medical_history' => $validated['medical_history'] ?? null,
                'allergies'       => $validated['allergies'] ?? null,
                'medications'     => $validated['medications'] ?? null,
            ]);

            // Handle new patient files if provided
            if (!empty($validated['patient_files'])) {
                foreach ($validated['patient_files'] as $fileInput) {
                    if (isset($fileInput['file']) && $fileInput['file'] instanceof \Illuminate\Http\UploadedFile) {
                        $fileObject = $fileInput['file'];

                        $fileName = 'patient_' . time() . '_' . uniqid() . '.' . $fileObject->getClientOriginalExtension();
                        $destinationPath =  base_path('../public_html/patient_files');
                       
                        $fileObject->move($destinationPath, $fileName);

                        PatientFile::create([
                            'patient_id' => $patient->id,
                            'title'      => $fileInput['title'] ?? '',
                            'file_path'  => 'patient_files/' . $fileName,
                            'type'       => $fileInput['type'] ?? null,
                        ]);
                    }
                }
            }
        });

        Alert::success('تم تعديل بيانات المريض بنجاح.');
        return redirect()->route('doctor.patients');
    } catch (\Exception $e) {
        Alert::warning('حدث خطأ أثناء التحديث: ' . $e->getMessage());
        return redirect()->route('doctor.patients');
    }
}


    public function show($patient)
    {
        $patient_id = decrypt($patient);
        $patient = Patient::with('files')->findOrFail($patient_id);
        return view('doctor.patient.show', compact('patient'));
    }

    public function changeStatus($id)
    {
        $patient_id = decrypt($id);
        $patient = Patient::find($patient_id);

        try {
            DB::transaction(function () use ($patient) {
                $patient->active = $patient->active == 1 ? 0 : 1;
                $patient->save();
            });

            Alert::success('تم تغيير حالة المريض بنجاح.');
            return redirect()->route('doctor.patients');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            return redirect()->route('doctor.patients');
        }
    }

    public function generateNewPassword($patient)
    {
        $patient_id = decrypt($patient);
        $patient = Patient::findOrFail($patient_id);

        $newPassword = \Illuminate\Support\Str::random(8);
        $patient->password = bcrypt($newPassword);
        $patient->save();

        return response()->json(['new_password' => $newPassword]);
    }

    public function sendPatientDataWhatsApp($patient)
    {
        $patient_id = decrypt($patient);
        $patient = Patient::findOrFail($patient_id);

        // Generate new password
        $newPassword = \Illuminate\Support\Str::random(8);
        $patient->password = bcrypt($newPassword);
        $patient->save();

        // Construct login URL (adjust route as needed)
        $loginUrl = route('patient.login');

        $message = "مرحباً " . $patient->full_name . "%0A";
        $message .= "هذه بياناتك:%0A";
        $message .= "رقم المريض: " . $patient->patient_number . "%0A";
        $message .= "البريد الإلكتروني: " . $patient->email . "%0A";
        $message .= "رابط تسجيل الدخول: " . $loginUrl . "%0A";
        $message .= "كلمة المرور: " . $newPassword . "%0A";

        $phone = preg_replace('/[^0-9]/', '', $patient->contact_number);
        if (substr($phone, 0, 1) === '0') {
            $phone = '218' . substr($phone, 1); // Adjust country code as needed
        }
        $whatsappUrl = "https://wa.me/" . $phone . "?text=" . $message;

        return redirect()->away($whatsappUrl);
    }
}
