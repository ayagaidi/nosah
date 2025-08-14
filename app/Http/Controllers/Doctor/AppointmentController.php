<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Clinic;
use Illuminate\Http\Request;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class AppointmentController extends Controller
{
    public function searchForm()
    {
        return view('doctor.appointment.search');
    }

    public function search(Request $request)
    {
        $request->validate(['patient_number' => 'required']);
        $patient = Patient::where('patient_number', $request->patient_number)->first();
        if (!$patient) {
            Alert::error('خطأ', 'المريض غير موجود');
            return back();
        }
        return redirect()->route('doctor.appointments.index', $patient->id);
    }

    public function index($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        return view('doctor.appointment.index', compact('patient'));
    }

    public function ajax($patient_id)
    {
        $appointments = Appointment::with(['doctor', 'clinic'])
            ->where('patient_id', $patient_id)
            ->orderBy('scheduled_at', 'desc');

        return datatables()->of($appointments)
            ->addColumn('clinic', function ($appointment) {
                return $appointment->clinic ? $appointment->clinic->name : '-';
            })
            ->addColumn('doctor', function ($appointment) {
                return $appointment->doctor ? $appointment->doctor->fullname : '-';
            })
            ->editColumn('appointment_type', function ($appointment) {
                return $appointment->appointment_type == 'مجاني'
                    ? 'مجاني (أسبوع مجاني)'
                    : $appointment->appointment_type;
            })
            ->addColumn('attendance', function ($appointment) {
                $now = \Carbon\Carbon::now()->startOfDay();
                $appointmentDate = \Carbon\Carbon::parse($appointment->scheduled_at)->startOfDay();
                // if ($appointmentDate->isFuture()) {
                //     // If appointment date is in the future, show hint message
                //     return '<span class="badge badge-pill badge-info" style="font-size:13px;padding:6px 12px;">لم يتم الوصول بعد</span>';
                // } else {
                    // تصميم احترافي للحضور والغياب
                    $presentBtn = '<button class="btn btn-outline-success btn-xs toggle-attendance" data-id="' . $appointment->id . '" data-status="present" style="margin:2px 2px;">'
                        . '<i class="fa fa-check"></i> حضر</button>';
                    $absentBtn = '<button class="btn btn-outline-danger btn-xs toggle-attendance" data-id="' . $appointment->id . '" data-status="absent" style="margin:2px 2px;">'
                        . '<i class="fa fa-times"></i> غياب</button>';
                    $current = '';
                    if ($appointment->attendance_status === 'present') {
                        $current = '<span class="badge badge-pill badge-success" style="font-size:13px;padding:6px 12px;"><i class="fa fa-check"></i> حضر</span>';
                        // Add confirmation printout button or message
                        $confirmation = '';
                        $buttons = ''; // Hide buttons if present
                    } elseif ($appointment->attendance_status === 'absent') {
                        $current = '<span class="badge badge-pill badge-danger" style="font-size:13px;padding:6px 12px;"><i class="fa fa-times"></i> غياب</span>';
                        $confirmation = '';
                        $buttons = '';
                    } else {
                        $current = '<span class="badge badge-pill badge-secondary" style="font-size:13px;padding:6px 12px;"><i class="fa fa-question"></i> غير محدد</span>';
                        $confirmation = '';
                        $buttons = $presentBtn . ' ' . $absentBtn;
                    }
                    return '<div style="display:flex;flex-direction:column;align-items:center;gap:4px;">'
                        . $current
                        . '<div>' . $buttons . '</div>'
                        . $confirmation
                        . '</div>';
                // }
            })
            ->addColumn('actions', function ($appointment) use ($patient_id) {
                $edit = route('doctor.appointments.edit', [$patient_id, $appointment->id]);
                $disabled = ($appointment->attendance_status === 'present' || $appointment->attendance_status === 'absent') ? 'pointer-events:none;opacity:0.5;' : '';
                return '<a style="color: #f97424;' . $disabled . '" href="' . $edit . '"><i class="fa fa-edit"> </i></a>';
            })
            ->rawColumns(['attendance', 'actions'])
            ->make(true);
    }

    public function toggleAttendance(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:appointments,id',
            'status' => 'required|in:present,absent'
        ]);
        $appointment = Appointment::findOrFail($request->id);
        $appointment->attendance_status = $request->status;
        $appointment->save();

        return response()->json(['success' => true]);
    }

    public function create($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $doctor = auth('doctor')->user();
        // تأكد أن العلاقة clinics معرفة في موديل Doctor بهذا الشكل:
        // public function clinics() { return $this->belongsToMany(Clinic::class, ...); }
        $clinics = method_exists($doctor, 'clinics') ? $doctor->clinics : [];
        return view('doctor.appointment.create', compact('patient', 'doctor', 'clinics'));
    }

    public function store(Request $request, $patient_id)
    {
        $request->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'scheduled_at' => 'required|date|after:now',
            'appointment_type' => 'required|in:كشف,متابعة,استشارة,مجاني,مراجعة',
            'notes' => 'nullable|string',
        ]);
        $doctor = auth('doctor')->user();

        $startOfWeek = \Carbon\Carbon::parse($request->scheduled_at)->startOfWeek();
        $endOfWeek = \Carbon\Carbon::parse($request->scheduled_at)->endOfWeek();

        // منع أكثر من موعد في نفس الأسبوع
        $exists = \App\Models\Appointment::where('patient_id', $patient_id)
            ->whereBetween('scheduled_at', [$startOfWeek, $endOfWeek])
            ->where('status', '!=', 'cancelled')
            ->exists();
        if ($exists) {
            \RealRashid\SweetAlert\Facades\Alert::error('خطأ', 'لا يمكن إضافة أكثر من موعد للمريض في نفس الأسبوع.');
            return back()->withInput();
        }

        // منع الجمع بين مجاني وكشف في نفس الأسبوع
        $typeExists = \App\Models\Appointment::where('patient_id', $patient_id)
            ->whereBetween('scheduled_at', [$startOfWeek, $endOfWeek])
            ->whereIn('appointment_type', ['كشف', 'مجاني'])
            ->where('status', '!=', 'cancelled')
            ->exists();
        if ($typeExists && in_array($request->appointment_type, ['كشف', 'مجاني'])) {
            \RealRashid\SweetAlert\Facades\Alert::error('خطأ', 'لا يمكن الجمع بين موعد مجاني وموعد كشف في نفس الأسبوع.');
            return back()->withInput();
        }

        // إضافة الموعد المطلوب
        $appointment = \App\Models\Appointment::create([
            'patient_id' => $patient_id,
            'doctor_id' => $doctor->id,
            'clinic_id' => $request->clinic_id,
            'scheduled_at' => $request->scheduled_at,
            'appointment_type' => $request->appointment_type,
            'status' => 'scheduled',
            'created_by' => $doctor->id,
            'notes' => $request->notes,
        ]);

        // إذا كان الموعد مراجعة، أضف موعد مجاني للأسبوع التالي تلقائياً
        if ($request->appointment_type == 'مراجعة') {
            $nextWeek = \Carbon\Carbon::parse($request->scheduled_at)->addWeek()->startOfWeek();
            $nextWeekEnd = $nextWeek->copy()->endOfWeek();

            // تحقق أنه لا يوجد موعد مجاني في الأسبوع القادم
            $freeExists = \App\Models\Appointment::where('patient_id', $patient_id)
                ->whereBetween('scheduled_at', [$nextWeek, $nextWeekEnd])
                ->where('appointment_type', 'مجاني')
                ->where('status', '!=', 'cancelled')
                ->exists();

            if (!$freeExists) {
               // \App\Models\Appointment::create([
                  //  'patient_id' => $patient_id,
                  //  'doctor_id' => $doctor->id,
                 //   'clinic_id' => $request->clinic_id,
                //    'scheduled_at' => $nextWeek->copy()->addDays(1)->setTime(10, 0), // يوم الاثنين الساعة 10 مثلاً
                  //  'appointment_type' => 'مجاني',
                   // 'status' => 'scheduled',
                   // 'created_by' => $doctor->id,
                  //  'notes' => 'موعد مجاني تلقائي بعد مراجعة',
              //  ]);
            }
        }

        // إذا كان الموعد مجاني، تأكد أنه لا يوجد غيره في نفس الأسبوع
        if ($request->appointment_type == 'مجاني') {
            // لا يمكن إضافة أكثر من موعد مجاني في نفس الأسبوع (تم التحقق أعلاه)
            // يمكن إضافة منطق إضافي هنا إذا أردت تقييد المريض بعدم الحجز إلا في أسبوع مجاني واحد فقط
            \RealRashid\SweetAlert\Facades\Alert::info('تنبيه', 'تم حجز موعد مجاني في هذا الأسبوع بالفعل.');
            return back()->withInput();
        }

        \RealRashid\SweetAlert\Facades\Alert::success('نجاح', 'تم إضافة الموعد بنجاح.');
        return redirect()->route('doctor.appointments.index', $patient_id);
    }

    public function edit($patient_id, $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $patient = Patient::findOrFail($patient_id);
        $doctor = auth('doctor')->user();
        $clinics = $doctor->clinics;
        return view('doctor.appointment.edit', compact('appointment', 'patient', 'doctor', 'clinics'));
    }

    public function update(Request $request, $patient_id, $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $request->validate([
            'clinic_id' => 'required|exists:clinics,id',
            'scheduled_at' => 'required|date|after:now',
            'appointment_type' => 'required|in:كشف,مراجعة,استشارة,مجاني',
            'notes' => 'nullable|string',
        ]);
        $doctor = auth('doctor')->user();

        // تحقق من عدم وجود موعد آخر في نفس الأسبوع (عدا هذا الموعد)
        $startOfWeek = Carbon::parse($request->scheduled_at)->startOfWeek();
        $endOfWeek = Carbon::parse($request->scheduled_at)->endOfWeek();
        $exists = Appointment::where('patient_id', $patient_id)
            ->whereBetween('scheduled_at', [$startOfWeek, $endOfWeek])
            ->where('id', '!=', $appointment_id)
            ->where('status', '!=', 'cancelled')
            ->exists();
        if ($exists) {
            Alert::error('خطأ', 'لا يمكن إضافة أكثر من موعد للمريض في نفس الأسبوع.');
            return back()->withInput();
        }

        // منع الجمع بين مجاني وكشف في نفس الأسبوع
        $typeExists = Appointment::where('patient_id', $patient_id)
            ->whereBetween('scheduled_at', [$startOfWeek, $endOfWeek])
            ->whereIn('appointment_type', ['كشف', 'مجاني'])
            ->where('id', '!=', $appointment_id)
            ->where('status', '!=', 'cancelled')
            ->exists();
        if ($typeExists && in_array($request->appointment_type, ['كشف', 'مجاني'])) {
            Alert::error('خطأ', 'لا يمكن الجمع بين موعد مجاني وموعد كشف في نفس الأسبوع.');
            return back()->withInput();
        }

        $appointment->update([
            'clinic_id' => $request->clinic_id,
            'scheduled_at' => $request->scheduled_at,
            'appointment_type' => $request->appointment_type,
            'notes' => $request->notes,
            'updated_by' => $doctor->id,
            'status' => 'rescheduled',
            'rescheduled_at' => now(),
            'reschedule_reason' => $request->reschedule_reason,
        ]);
        Alert::success('نجاح', 'تم تعديل الموعد بنجاح.');
        return redirect()->route('doctor.appointments.index', $patient_id);
    }
}
