<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\doctor;
use App\Models\Patient;
use App\Models\PatientDietPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

class PatientDietPlanController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth:doctor');
    }
    // عرض نموذج البحث عن المريض
    public function searchPatientForm()
    {
        return view('doctor.diet_plan.search');
    }

    // معالجة البحث عن المريض برقم المريض
    public function searchPatient(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|string',
        ]);
        $patient = Patient::where('patient_number', $request->input('patient_id'))->first();
        if (!$patient) {
            FacadesAlert::error('خطأ', 'المريض غير موجود');
            return back()->withErrors(['patient_id' => 'المريض غير موجود']);
        }
        FacadesAlert::success('نجاح', 'تم العثور على المريض بنجاح.');
        return redirect()->route('doctor.diet_plans.index', $patient->id);
    }

    public function index($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        // لا حاجة لتعديل هنا لأن الجدول سيجلب الطبيب عبر ajax
        return view('doctor.diet_plan.index', compact('patient'));
    }

    public function create($patient_id = null)
    {
        if (!$patient_id) {
            return redirect()->route('doctor.diet_plans.search.form');
        }
        $patient = Patient::findOrFail($patient_id);
        return view('doctor.diet_plan.create', compact('patient'));
    }

    public function store(Request $request, $patient_id)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'meal_type' => 'required|string|max:50',
            'food_category' => 'nullable|string|max:50',
            'food_item' => 'required|string|max:100',
            'portion_size' => 'nullable|string|max:50',
            'calories' => 'nullable|integer',
            'carbs' => 'nullable|numeric',
            'protein' => 'nullable|numeric',
            'fat' => 'nullable|numeric',
            'fiber' => 'nullable|numeric',
            'fluid_intake' => 'nullable|string|max:50',
            'supplements' => 'nullable|string|max:100',
            'special_instructions' => 'nullable|string',
            'dietary_restrictions' => 'nullable|string',
            'compliance_notes' => 'nullable|string',
            'prescribed_by' => 'nullable|integer',
            'date_prescribed' => 'nullable|date',
        ]);
        $data['patient_id'] = $patient_id;
        $data['prescribed_by'] = auth('doctor')->id();
        $data['date_prescribed'] = $data['date_prescribed'] ?? now();
        $data['food_category'] = $data['food_category'] ??'لايوجد';

        PatientDietPlan::create($data);

        FacadesAlert::success('نجاح', 'تمت إضافة الخطة بنجاح.');
        return redirect()->route('doctor.diet_plans.index', $patient_id);
    }

    public function show($patient_id, $plan_id)
    {
        $plan = PatientDietPlan::findOrFail($plan_id);
        $patient = Patient::findOrFail($patient_id);
         $doctor =doctor::find($plan->prescribed_by);
        return view('doctor.diet_plan.show', compact('plan', 'patient','doctor'));
    }

    public function edit($patient_id, $plan_id)
    {
        $plan = PatientDietPlan::findOrFail($plan_id);
        $patient = Patient::findOrFail($patient_id);
        return view('doctor.diet_plan.edit', compact('plan', 'patient'));
    }

    public function update(Request $request, $patient_id, $plan_id)
    {
        $plan = PatientDietPlan::findOrFail($plan_id);
        $data = $request->validate([
            'date' => 'required|date',
            'meal_type' => 'required|string|max:50',
            'food_category' => 'nullable|string|max:50',
            'food_item' => 'required|string|max:100',
            'portion_size' => 'nullable|string|max:50',
            'calories' => 'nullable|integer',
            'carbs' => 'nullable|numeric',
            'protein' => 'nullable|numeric',
            'fat' => 'nullable|numeric',
            'fiber' => 'nullable|numeric',
            'fluid_intake' => 'nullable|string|max:50',
            'supplements' => 'nullable|string|max:100',
            'special_instructions' => 'nullable|string',
            'dietary_restrictions' => 'nullable|string',
            'compliance_notes' => 'nullable|string',
            'prescribed_by' => 'nullable|integer',
            'date_prescribed' => 'nullable|date',
        ]);
        $plan->update($data);

        FacadesAlert::success('نجاح', 'تم تحديث الخطة بنجاح.');
        return redirect()->route('doctor.diet_plans.index', $patient_id);
    }

    public function destroy($patient_id, $plan_id)
    {
        $plan = PatientDietPlan::findOrFail($plan_id);
        $plan->delete();
        FacadesAlert::success('نجاح', 'تم حذف الخطة بنجاح.');
        return redirect()->route('doctor.diet_plans.index', $patient_id);
    }

    public function ajax($patient_id)
    {
        $plans = PatientDietPlan::with('doctor')->where('patient_id', $patient_id)->orderBy('date', 'desc');
        return DataTables::of($plans)
            ->addColumn('doctor', function($plan) {
                $doctor = doctor::find($plan->prescribed_by);
                return $doctor ? $doctor->fullname : '-';
            })
            ->addColumn('show', function($plan) use ($patient_id) {
                $show = route('doctor.diet_plans.show', [$patient_id, $plan->id]);
                return '<a style="" href="'.$show.'"><i class="fa fa-file"></i></a>';
            })
            ->addColumn('edit', function($plan) use ($patient_id) {
                $edit = route('doctor.diet_plans.edit', [$patient_id, $plan->id]);
                // زر التعديل بالتصميم المطلوب فقط
                return '<a style="color: #f97424;" href="'.$edit.'"><i class="fa fa-edit"> </i></a>';
            })
            ->addColumn('delete', function($plan) use ($patient_id) {
                $delete = route('doctor.diet_plans.delete', [$patient_id, $plan->id]);
                return '
                    <a style="color: red;" href="#" onclick="event.preventDefault(); if(confirm(\'تأكيد الحذف؟\')){ document.getElementById(\'delete-form-'.$plan->id.'\').submit(); }"><i class="fa fa-trash"></i></a>
                    <form id="delete-form-'.$plan->id.'" action="'.$delete.'" method="POST" style="display:none;">
                        '.csrf_field().method_field('DELETE').'
                    </form>
                ';
            })
            ->rawColumns(['show', 'edit', 'delete'])
            ->make(true);
    }
}
