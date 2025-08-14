<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Clinic;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class ClinicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        ActivityLogger::activity('تسجيل عرض جميع العيادات');
        return view('dashbord.clinics.index');
    }

    public function clinics()
    {
        $clinics = Clinic::select(['id', 'name', 'address', 'phone_number', 'url_location', 'created_at', 'active'])->orderBy('created_at', 'DESC');
        return datatables()->of($clinics)
            ->addColumn('edit', function ($clinic) {
                $clinic_id = encrypt($clinic->id);
                return '<a style="color: #f97424;" href="' . route('clinics/edit', $clinic_id) . '"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('changeStatus', function ($clinic) {
                $clinic_id = encrypt($clinic->id);
                $btnClass = $clinic->active ? 'btn-success' : 'btn-secondary';
                $btnText = $clinic->active ? 'تعطيل' : 'تفعيل';
                $icon = $clinic->active ? '<i class="fa fa-toggle-on"></i>' : '<i class="fa fa-toggle-off"></i>';
                return '<a href="' . route('clinics/changeStatus', $clinic_id) . '" class="btn btn-sm '.$btnClass.'" title="'.$btnText.'">'.$icon.' '.$btnText.'</a>';
            })
            ->addColumn('viewDoctors', function ($clinic) {
                $clinic_id = encrypt($clinic->id);
                return '<a href="' . route('clinics/doctors', $clinic_id) . '" ><i class="fa fa-user-md"></i></a>';
            })
            ->rawColumns(['edit', 'changeStatus', 'url_location', 'viewDoctors'])
            ->make(true);
    }

    public function create()
    {
        $cities = City::all();
        ActivityLogger::activity('Logger of Create Clinic page');
        return view('dashbord.clinics.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'اسم العيادة مطلوب.',
            'cities_id.required' => 'المدينة مطلوبة.',
        ];
        $this->validate($request, [
            'name' => ['required', 'string', 'max:50', 'unique:clinics'],
            'cities_id' => ['required', 'exists:cities,id'],
            'url_location' => ['nullable', 'url'],
        ], $messages);

        try {
            DB::transaction(function () use ($request) {
                $clinic = new Clinic();
                $clinic->name = $request->name;
                $clinic->address = $request->address;
                $clinic->phone_number = $request->phone_number;
                $clinic->url_location = $request->url_location;
                $clinic->cities_id = $request->cities_id;
                $clinic->save();
            });

            Alert::success('تمت إضافة العيادة بنجاح.');
            ActivityLogger::activity($request->name . ' تمت إضافته بنجاح إلى العيادات.');

            return redirect()->route('clinics');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->name . ' فشل في الإضافة إلى العيادات.');

            return redirect()->route('clinics');
        }
    }

    public function edit($clinic)
    {
        $clinic_id = decrypt($clinic);
        $clinic = Clinic::find($clinic_id);
        $cities = City::all();
        ActivityLogger::activity('تسجيل عرض صفحة تعديل العيادات');
        return view('dashbord.clinics.edit', compact('clinic', 'cities'));
    }

    public function update(Request $request, $clinic)
    {
        $clinic_id = decrypt($clinic);

        $messages = [
            'name.required' => 'اسم العيادة مطلوب.',
            'cities_id.required' => 'المدينة مطلوبة.',
        ];
        $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
            'cities_id' => ['required', 'exists:cities,id'],
            'url_location' => ['nullable', 'url'],
        ], $messages);

        try {
            DB::transaction(function () use ($request, $clinic_id) {
                $clinic = Clinic::find($clinic_id);
                $clinic->name = $request->name;
                $clinic->address = $request->address;
                $clinic->phone_number = $request->phone_number;
                $clinic->url_location = $request->url_location;
                $clinic->cities_id = $request->cities_id;
                $clinic->save();
                ActivityLogger::activity($clinic->name . ' تم تعديل العيادة بنجاح.');
            });

            Alert::success('تم تعديل العيادة بنجاح');
            return redirect()->route('clinics');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->name . ' فشل تعديل العيادة.');

            return redirect()->route('clinics');
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $clinic_id = decrypt($id);
        $clinic = Clinic::find($clinic_id);

        try {
            DB::transaction(function () use ($clinic) {
                $clinic->active = $clinic->active == 1 ? 0 : 1;
                $clinic->save();
            });

            ActivityLogger::activity($clinic->name . ' تم تغيير حالة العيادة بنجاح.');
            Alert::success('تم تغيير حالة العيادة بنجاح.');

            return redirect()->route('clinics');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($clinic->name . ' فشل في تغيير حالة العيادة.');

            return redirect()->route('clinics');
        }
    }

    public function doctors($clinic)
    {
        $clinics_id = decrypt($clinic);
        $clinic = Clinic::with(['doctors' => function ($query) {
            $query->select('doctors.*')->with('specializations'); // Include specialization relationship
        }])->find($clinics_id);

        if (!$clinic) {
            Alert::warning('العيادة غير موجودة.');
            return redirect()->route('clinics');
        }

        ActivityLogger::activity('عرض الأطباء والتخصصات للعيادة: ' . $clinic->name);
        return view('dashbord.clinics.doctors', compact('clinic'));
    }
}
