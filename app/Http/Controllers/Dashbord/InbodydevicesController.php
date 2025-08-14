<?php

namespace App\Http\Controllers\Dashbord;

use App\Http\Controllers\Controller;
use App\Models\Inbodydevices;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use jeremykenedy\LaravelLogger\App\Http\Traits\ActivityLogger;

class InbodydevicesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        ActivityLogger::activity('عرض جميع أجهزة InBody');
        $devices = Inbodydevices::all();
        return view('dashbord.inbodydevices.index', compact('devices'));
    }

    public function create()
    {
        ActivityLogger::activity('عرض صفحة إضافة جهاز InBody جديد');
        $cities = City::all(); // Fetch all cities
        return view('dashbord.inbodydevices.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $messages = [
            'url.required' => 'رابط الجهاز مطلوب.',
            'url.url' => 'يجب أن يكون الرابط صالحاً.',
            'place_name.required' => 'اسم  مطلوب.',
            'cities_id.required' => 'معرف المدينة مطلوب.',
            'device_model.required' => 'موديل الجهاز مطلوب.',
        ];

        $this->validate($request, [
            'url' => 'required|url',
            'place_name' => 'required|string|max:255',
            'cities_id' => 'required|integer',
            'device_model' => 'required|string|max:255',
        ], $messages);

        try {
            DB::transaction(function () use ($request) {
                $device = new Inbodydevices();
                $device->url = $request->url;
                $device->place_name = $request->place_name;
                $device->cities_id = $request->cities_id;
                $device->device_model = $request->device_model;
                $device->save();
            });

            Alert::success('تمت إضافة الجهاز بنجاح.');
            ActivityLogger::activity('تمت إضافة جهاز InBody جديد بنجاح.');

            return redirect()->route('inbodydevices');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity('فشل في إضافة جهاز InBody جديد.');

            return redirect()->route('inbodydevices');
        }
    }

    public function show(Inbodydevices $inbodydevice)
    {
        ActivityLogger::activity('عرض تفاصيل جهاز InBody');
        return view('dashbord.inbodydevices.show', compact('inbodydevice'));
    }

    public function edit($inbodydevice)
    {
        $inbodydevice_id = decrypt($inbodydevice);
        ActivityLogger::activity('عرض صفحة تعديل جهاز InBody');
        $cities = City::all(); // Fetch all cities
        $inbodydevice =Inbodydevices::find($inbodydevice_id);
        return view('dashbord.inbodydevices.edit', compact('inbodydevice', 'cities'));
    }

    public function update(Request $request, Inbodydevices $inbodydevice)
    {
        $messages = [
            'url.required' => 'رابط الجهاز مطلوب.',
            'url.url' => 'يجب أن يكون الرابط صالحاً.',
            'place_name.required' => 'اسم  مطلوب.',
            'cities_id.required' => 'معرف المدينة مطلوب.',
            'device_model.required' => 'موديل الجهاز مطلوب.',
        ];

        $this->validate($request, [
            'url' => 'required|url',
            'place_name' => 'required|string|max:255',
            'cities_id' => 'required|integer',
            'device_model' => 'required|string|max:255',
        ], $messages);

        try {
            DB::transaction(function () use ($request, $inbodydevice) {
                $inbodydevice->url = $request->url;
                $inbodydevice->place_name = $request->place_name;
                $inbodydevice->cities_id = $request->cities_id;
                $inbodydevice->device_model = $request->device_model;
                $inbodydevice->save();
            });

            Alert::success('تم تعديل الجهاز بنجاح.');
            ActivityLogger::activity('تم تعديل جهاز InBody بنجاح.');

            return redirect()->route('inbodydevices');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity('فشل تعديل جهاز InBody.');

            return redirect()->route('inbodydevices');
        }
    }

    public function destroy(Inbodydevices $inbodydevice)
    {
        try {
            DB::transaction(function () use ($inbodydevice) {
                $inbodydevice->delete();
            });

            Alert::success('تم حذف الجهاز بنجاح.');
            ActivityLogger::activity('تم حذف جهاز InBody بنجاح.');

            return redirect()->route('inbodydevices.index');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity('فشل حذف جهاز InBody.');

            return redirect()->route('inbodydevices.index');
        }
    }

    public function inbodydevices()    {     
           $devices = Inbodydevices::with('cities')->orderBy('created_at', 'DESC');        return datatables()->of($devices)            ->addColumn('edit', function ($device) {                $device_id = encrypt($device->id);
                return '<a style="color: #f97424;" href="' . route('inbodydevices/edit', $device_id) . '"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('changeStatus', function ($device) {
                $device_id = encrypt($device->id);

                return '<a href="' . route('inbodydevices/changeStatus', $device_id) . '"><i class="fa fa-refresh"></i></a>';
            })
            ->rawColumns(['edit', 'changeStatus'])
            ->make(true);
    }

    public function changeStatus(Request $request, $id)
    {
        $device_id = decrypt($id);
        $device = Inbodydevices::find($device_id);

        try {
            DB::transaction(function () use ($device) {
                $device->active = $device->active == 1 ? 0 : 1;
                $device->save();
            });

            ActivityLogger::activity($device->place_name . ' تم تغيير حالة الجهاز بنجاح.');
            Alert::success('تم تغيير حالة الجهاز بنجاح.');

            return redirect()->route('inbodydevices');
        } catch (\Exception $e) {
            Alert::warning($e->getMessage());
            ActivityLogger::activity($device->place_name . ' فشل في تغيير حالة الجهاز.');

            return redirect()->route('inbodydevices');
        }
    }
}
