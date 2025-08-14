<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Specializations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class SpecializationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        ActivityLogger::activity('تسجيل عرض جميع المدن');

        return view('dashbord.specializations.index');
    }

    public function specializations()
    {
        $Specializations = Specializations::orderBy('created_at', 'DESC');
        return datatables()->of($Specializations)
            ->addColumn('edit', function ($Specializations) {
                $Specializations_id = encrypt($Specializations->id);

                return '<a style="color: #f97424;" href="' . route('specializations/edit', $Specializations_id) . '"><i  class="fa  fa-edit" > </i></a>';
            })
            ->addColumn('changeStatus', function ($specializations) {
                $specializations_id = encrypt($specializations->id);

                return '<a href="' . route('specializations/changeStatus', $specializations_id) . '"><i  class="fa  fa-refresh"> </i></a>';
            })
            
            ->rawColumns(['edit', 'changeStatus'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        ActivityLogger::activity('Logger of Create Specialization page');

        return view('dashbord.specializations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'اسم التخصص مطلوب.',
        ];
        $this->validate($request, [
            'name' => ['required', 'string', 'max:50', 'unique:cities'],
        ], $messages);
        try {
            DB::transaction(function () use ($request) {
                $specializations = new Specializations();
                $specializations->name = $request->name;
                $specializations->save();
            });
            Alert::success('تمت إضافة التخصص بنجاح.');
            ActivityLogger::activity($request->name . ' تمت إضافته بنجاح إلى التخصصات.');

            return redirect()->route('specializations');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->name . ' فشل في الإضافة إلى التخصصات.');

            return redirect()->route('specializations');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Specializations $specializations)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($specializations)
    {
        $specializations_id = decrypt($specializations);
        $specialization = Specializations::find($specializations_id);
        ActivityLogger::activity('تسجيل عرض صفحة تعديل التخصصات');
        return view('dashbord.specializations.edit')->with('specialization', $specialization); // تعديل الرسالة إلى اللغة العربية
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $specialization)
    {
        $specialization_id = decrypt($specialization);

        $messages = [
            'name.required' => 'اسم التخصص مطلوب.',
        ];
        $this->validate($request, [
            'name' => ['required', 'string', 'max:50'],
        ], $messages);
        try {
            DB::transaction(function () use ($request, $specialization) {
                $specialization_id = decrypt($specialization);

                $specialization = Specializations::find($specialization_id);
                $specialization->name = $request->name;

                $specialization->save();
                ActivityLogger::activity('تسجيل تعديل صفحة التخصصات');

                ActivityLogger::activity($specialization->name . ' تم تعديل التخصص بنجاح.');
            });

            Alert::success('تم تعديل التخصص بنجاح');

            return redirect()->route('specializations');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($request->name . ' فشل تعديل التخصص.');

            return redirect()->route('specializations');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Specializations $specializations)
    {
        //
    }

    /**
     * Change the active status of the specified resource.
     */
    public function changeStatus(Request $request, $id)
    {
        $specialization_id = decrypt($id);
        $specialization = Specializations::find($specialization_id);

        try {
            DB::transaction(function () use ($specialization) {
                $specialization->active = $specialization->active == 1 ? 0 : 1;
                $specialization->save();
            });

            ActivityLogger::activity($specialization->name . ' تم تغيير حالة التخصص بنجاح.');
            Alert::success('تم تغيير حالة التخصص بنجاح.');

            return redirect()->route('specializations');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($specialization->name . ' فشل في تغيير حالة التخصص.');

            return redirect()->route('specializations');
        }
    }
}
